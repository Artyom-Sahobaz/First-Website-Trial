<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

require_once '../includes/config.php';

if (!isset($_GET['id'])) {
    die("Article not found.");
}

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->execute([$id]);

$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    die("Article not found.");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title']);
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));
    $category = $_POST['category'];
    $excerpt = $_POST['excerpt'];
    $content = $_POST['content'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = $_POST['status'];

    // Keep the existing image by default
    $featured_image = $article['featured_image'];

    // Replace it only if a new image is uploaded
    if (!empty($_FILES['featured_image']['name'])) {

        $filename = time() . "_" . basename($_FILES['featured_image']['name']);

        $target = "../images/" . $filename;

        if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $target)) {
            $featured_image = "images/" . $filename;
        }
    }

    $stmt = $pdo->prepare("
        UPDATE articles
        SET
            title = ?,
            slug = ?,
            category = ?,
            excerpt = ?,
            content = ?,
            featured_image = ?,
            meta_title = ?,
            meta_description = ?,
            meta_keywords = ?,
            status = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $title,
        $slug,
        $category,
        $excerpt,
        $content,
        $featured_image,
        $meta_title,
        $meta_description,
        $meta_keywords,
        $status,
        $id
    ]);

    header("Location: articles.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<title>Edit Article</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jodit/4.7.6/es2021/jodit.min.css">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial,sans-serif;
}

body{
background:#f4f6f9;
padding:40px;
}

.container{
max-width:900px;
margin:auto;
background:#fff;
padding:30px;
border-radius:10px;
box-shadow:0 5px 15px rgba(0,0,0,.08);
}

h1{
margin-bottom:30px;
}

.form-group{
margin-bottom:20px;
}

label{
display:block;
margin-bottom:8px;
font-weight:bold;
}

input,
select,
textarea{
width:100%;
padding:12px;
border:1px solid #ccc;
border-radius:6px;
font-size:15px;
}

textarea{
min-height:300px;
resize:vertical;
}

button{
background:#2d7d46;
color:#fff;
border:none;
padding:14px 30px;
border-radius:6px;
cursor:pointer;
font-size:16px;
}

button:hover{
background:#25673a;
}

.current-image{
margin-top:10px;
}

.current-image img{
width:220px;
border-radius:8px;
border:1px solid #ddd;
}

</style>

</head>

<body>

<div class="container">

<h1>Edit Article</h1>

<form action="" method="POST" enctype="multipart/form-data">

<div class="form-group">

<label>Title</label>

<input
type="text"
name="title"
value="<?= htmlspecialchars($article['title']); ?>"
required>

</div>

<div class="form-group">

<label>Category</label>

<select name="category">

<option value="Selling Tips" <?= $article['category']=="Selling Tips" ? "selected" : "" ?>>Selling Tips</option>

<option value="Buying" <?= $article['category']=="Buying" ? "selected" : "" ?>>Buying</option>

<option value="Guides" <?= $article['category']=="Guides" ? "selected" : "" ?>>Guides</option>

<option value="Financing" <?= $article['category']=="Financing" ? "selected" : "" ?>>Financing</option>

<option value="Maintenance" <?= $article['category']=="Maintenance" ? "selected" : "" ?>>Maintenance</option>

</select>

</div>

<div class="form-group">

<label>Excerpt</label>

<textarea name="excerpt" style="min-height:120px;"><?= htmlspecialchars($article['excerpt']); ?></textarea>

</div>

<div class="form-group">

<label>Featured Image</label>

<input type="file" name="featured_image">

<?php if(!empty($article['featured_image'])): ?>

<div class="current-image">

<p>Current Image</p>

<img src="../<?= htmlspecialchars($article['featured_image']); ?>">

</div>

<?php endif; ?>

</div>

<div class="form-group">

<label>Article Content</label>

<textarea id="editor" name="content"><?= htmlspecialchars($article['content']); ?></textarea>

</div>

<div class="form-group">

<label>SEO Title</label>

<input
type="text"
name="meta_title"
value="<?= htmlspecialchars($article['meta_title']); ?>">

</div>

<div class="form-group">

<label>SEO Description</label>

<textarea name="meta_description" style="min-height:120px;"><?= htmlspecialchars($article['meta_description']); ?></textarea>

</div>
<div class="form-group">

<label>SEO Keywords</label>

<input
type="text"
name="meta_keywords"
value="<?= htmlspecialchars($article['meta_keywords'] ?? ''); ?>">

</div>

<div class="form-group">

<label>Status</label>

<select name="status">

<option value="Published" <?= $article['status']=="Published" ? "selected" : "" ?>>Published</option>

<option value="Draft" <?= $article['status']=="Draft" ? "selected" : "" ?>>Draft</option>

</select>

</div>

<button type="submit">

Update Article

</button>

</form>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jodit/4.7.6/es2021/jodit.min.js"></script>

<script>
const editor = Jodit.make('#editor',{
    height:500
});
</script>

</body>

</html>