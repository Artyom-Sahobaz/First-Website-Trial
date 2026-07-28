<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

require_once '../includes/config.php';

// Fetch all articles
$stmt = $pdo->query("SELECT * FROM articles ORDER BY created_at DESC");
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<title>Manage Articles</title>

<style>
 .badge{
    display:inline-block;
    padding:6px 12px;
    border-radius:20px;
    font-size:13px;
    font-weight:600;
    color:#fff;
}

.badge-selling{
    background:#2e7d32;
}

.badge-buying{
    background:#1565c0;
}

.badge-guides{
    background:#7b1fa2;
}

.badge-financing{
    background:#ef6c00;
}

.badge-maintenance{
    background:#c62828;
}

.badge-other{
    background:#616161;
}   

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

.header{

display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:30px;

}

h1{
font-size:30px;
}

.btn{

background:#2d7d46;
color:white;
padding:12px 20px;
text-decoration:none;
border-radius:6px;

}

table{

width:100%;
border-collapse:collapse;
background:white;
box-shadow:0 5px 15px rgba(0,0,0,.08);

}

th,td{

padding:16px;
border-bottom:1px solid #eee;
text-align:left;

}

th{

background:#2d7d46;
color:white;

}

.action{

text-decoration:none;
margin-right:15px;

}

.edit{

color:#0066cc;

}
.view{
color:#2d7d46;
font-weight:bold;
}

.delete{

color:red;

}

</style>

</head>

<body>

<div class="header">

<h1>Manage Articles</h1>

<a href="add-article.php" class="btn">
+ Add New Article
</a>

</div>

<table>

<tr>

<tr>

<th>ID</th>
<th>Image</th>
<th>Title</th>
<th>Category</th>
<th>Status</th>
<th>Date</th>
<th>Actions</th>

</tr>

</tr>

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

$class = "badge-other";

switch($article['category']){

    case "Selling Tips":
        $class = "badge-selling";
        break;

    case "Buying":
        $class = "badge-buying";
        break;

    case "Guides":
        $class = "badge-guides";
        break;

    case "Financing":
        $class = "badge-financing";
        break;

    case "Maintenance":
        $class = "badge-maintenance";
        break;
}

?>

<span class="badge <?= $class; ?>">
    <?= htmlspecialchars($article['category']); ?>
</span>

</td>

<td><?= htmlspecialchars($article['status']); ?></td>

<td><?= date('M d, Y', strtotime($article['created_at'])); ?></td>

<td>

<a class="action view"
href="../article.php?slug=<?= urlencode($article['slug']); ?>"
target="_blank">
👁 View
</a>

<a class="action edit"
href="edit-article.php?id=<?= $article['id']; ?>">
✏ Edit
</a>

<a class="action delete"
href="delete-article.php?id=<?= $article['id']; ?>"
onclick="return confirm('Delete this article?');">
🗑 Delete
</a>

</td>

</tr>

<?php endforeach; ?>

</table>

</body>

</html>