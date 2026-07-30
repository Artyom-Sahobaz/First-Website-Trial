<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

require_once '../includes/config.php';
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

    $featured_image = "";

    if (!empty($_FILES['featured_image']['name'])) {

        $filename = time() . "_" . basename($_FILES['featured_image']['name']);

        $target = "../images/" . $filename;

        move_uploaded_file($_FILES['featured_image']['tmp_name'], $target);

        $featured_image = "images/" . $filename;
    }

    $stmt = $pdo->prepare("
        INSERT INTO articles
(title, slug, category, excerpt, content, featured_image, meta_title, meta_description, meta_keywords, status)
VALUES
(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
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
        $status
    ]);

    header("Location: articles.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jodit/4.7.6/es2021/jodit.min.css">

<meta charset="UTF-8">
<title>Add Article</title>

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

</style>

</head>

<body>

<div class="container">

<h1>Add New Article</h1>

<form action="" method="POST" enctype="multipart/form-data">

<div class="form-group">
<label>Title</label>
<input type="text" name="title" required>
</div>

<div class="form-group">
<label>Category</label>

<select name="category">

<option>Selling Tips</option>
<option>Buying</option>
<option>Guides</option>
<option>Financing</option>
<option>Maintenance</option>

</select>

</div>

<div class="form-group">
<label>Excerpt</label>
<textarea name="excerpt" style="min-height:120px;"></textarea>
</div>

<div class="form-group">
<label>Featured Image</label>
<input type="file" name="featured_image">
</div>

<div class="form-group">
<label>Article Content</label>
<textarea id="editor" name="content"></textarea>
</div>

<div class="form-group">
<label>SEO Title</label>
<input type="text" name="meta_title">
</div>

<div class="form-group">
<label>SEO Description</label>
<textarea name="meta_description" style="min-height:120px;"></textarea>
</div>
<div class="form-group">

    <label>SEO Keywords</label>

    <input
        type="text"
        name="meta_keywords"
        placeholder="mobile homes, cash buyers, sell mobile home">

</div>
<div class="form-group">

<label>Status</label>

<select name="status">

<option value="Published">Published</option>
<option value="Draft">Draft</option>

</select>

</div>

<button type="submit">
Publish Article
</button>

</form>


</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jodit/4.7.6/es2021/jodit.min.js"></script>

<script>
const editor = Jodit.make('#editor', {
    height: 500
});
</script>

</body>

</html>