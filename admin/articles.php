<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

require_once '../includes/config.php';

// Fetch all articles
// Search
$search = $_GET['search'] ?? '';

if ($search != '') {

    $stmt = $pdo->prepare("
        SELECT *
        FROM articles
        WHERE title LIKE ?
           OR category LIKE ?
           OR status LIKE ?
        ORDER BY created_at DESC
    ");

    $keyword = "%{$search}%";
    $stmt->execute([$keyword, $keyword, $keyword]);

} else {

    $stmt = $pdo->query("
        SELECT *
        FROM articles
        ORDER BY created_at DESC
    ");

}

$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Articles | Cash4MobileHomes Admin</title>

<link
rel="stylesheet"
href="css/admin.css">

<link
rel="preconnect"
href="https://fonts.googleapis.com">

<link
rel="preconnect"
href="https://fonts.gstatic.com"
crossorigin>

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<div class="admin-layout">

<?php include("sidebar.php"); ?>

<main class="main-content">

<header class="topbar">

<div>

<h1 class="page-title">

Manage Articles

</h1>

<p>

Manage, edit and publish website articles.

</p>

</div>

<div class="topbar-right">

<a
href="add-article.php"
class="btn success">

<i class="fa-solid fa-plus"></i>

Add Article

</a>

</div>

</header>


<section class="section">

<div class="form-card">

<div class="toolbar-header">

<div class="toolbar-title">

<h2>Article Manager</h2>

<p>

Search, edit and manage your website articles.

</p>

</div>

</div>

<form method="GET">

<div class="form-grid" style="margin-top:30px;">

<div class="form-group">

<label>Search Articles</label>

<input
type="text"
name="search"
placeholder="Search by title, category or status..."
value="<?= htmlspecialchars($search); ?>">

</div>

<div class="form-group" style="display:flex;align-items:flex-end;gap:10px;">

<button
type="submit"
class="btn success">

<i class="fa-solid fa-magnifying-glass"></i>

Search

</button>

<?php if($search != ''): ?>

<a
href="articles.php"
class="btn secondary">

Clear

</a>

<?php endif; ?>

</div>

</div>

</form>

</div>

</section>

<section class="section">

<div class="table-wrapper">

<table id="articleTable">

<thead>

<tr>

<th>ID</th>
<th>Image</th>
<th>Title</th>
<th>Category</th>
<th>Status</th>
<th>Date</th>
<th>Actions</th>

</tr>

</thead>

<tbody>

<?php if(count($articles) > 0): ?>

<?php foreach($articles as $article): ?>

<tr>

<td><?= $article['id']; ?></td>
<td>

<?php if (!empty($article['featured_image'])): ?>

<img src="../<?= htmlspecialchars($article['featured_image']); ?>"
     width="80"
     height="50"
     style="object-fit:cover;border-radius:6px;">

<?php else: ?>

No Image

<?php endif; ?>

</td>

<td><?= htmlspecialchars($article['title']); ?></td>

<td>

<?php

$categoryClass = 'badge';

switch ($article['category']) {

    case 'Selling Tips':
        $categoryClass .= ' success';
        break;

    case 'Buying':
        $categoryClass .= ' info';
        break;

    case 'Guides':
        $categoryClass .= ' primary';
        break;

    case 'Financing':
        $categoryClass .= ' warning';
        break;

    case 'Maintenance':
        $categoryClass .= ' danger';
        break;

    default:
        $categoryClass .= ' secondary';
        break;
}

?>

<span class="<?= $categoryClass; ?>">

<?= htmlspecialchars($article['category']); ?>

</span>

</td>

<td>

<?php

$statusClass = strtolower($article['status']) === 'published'
    ? 'badge success'
    : 'badge warning';

?>

<span class="<?= $statusClass; ?>">

<?= htmlspecialchars($article['status']); ?>

</span>

</td>

<td><?= date('M d, Y', strtotime($article['created_at'])); ?></td>

<td>

<div class="action-buttons">

<a
class="action-btn view"
href="../article.php?slug=<?= urlencode($article['slug']); ?>"
target="_blank"
title="View Article">

<i class="fa-solid fa-eye"></i>

</a>

<a
class="action-btn edit"
href="edit-article.php?id=<?= $article['id']; ?>"
title="Edit Article">

<i class="fa-solid fa-pen"></i>

</a>

<a
class="action-btn delete"
href="delete-article.php?id=<?= $article['id']; ?>"
onclick="return confirm('Delete this article?');"
title="Delete Article">

<i class="fa-solid fa-trash"></i>

</a>

</div>

</td>

</tr>

<?php endforeach; ?>
<?php else: ?>

<tr>

<td colspan="7" style="text-align:center;padding:40px;">

No articles found.

</td>

</tr>

<?php endif; ?>

</tbody>

</table>

</div>

</section>

</main>

</div>

</body>

</html>