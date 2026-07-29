<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

require_once '../includes/config.php';

// Total Articles
$totalArticles = $pdo->query("SELECT COUNT(*) FROM articles")->fetchColumn();

// Published Articles
$publishedArticles = $pdo->query("SELECT COUNT(*) FROM articles WHERE status='Published'")->fetchColumn();

// Draft Articles
$draftArticles = $pdo->query("SELECT COUNT(*) FROM articles WHERE status='Draft'")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    background:#f4f6f9;
}

.container{
    max-width:1200px;
    margin:40px auto;
    padding:20px;
}

h1{
    margin-bottom:10px;
    color:#222;
}

.subtitle{
    color:#666;
    margin-bottom:30px;
}

.stats{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
}

.card{
    background:#fff;
    border-radius:12px;
    padding:25px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.card h2{
    font-size:40px;
    color:#2c3e50;
    margin-bottom:10px;
}

.card p{
    color:#777;
    font-size:16px;
}

.actions{
    margin-top:40px;
}

.actions h2{
    margin-bottom:20px;
    color:#222;
}

.buttons{
    display:flex;
    flex-wrap:wrap;
    gap:15px;
}

.btn{
    display:inline-block;
    text-decoration:none;
    background:#2d6cdf;
    color:#fff;
    padding:14px 24px;
    border-radius:8px;
    transition:.3s;
}

.btn:hover{
    background:#1f56b3;
}

.logout{
    background:#dc3545;
}

.logout:hover{
    background:#b52a37;
}

.website{
    background:#28a745;
}

.website:hover{
    background:#218838;
}
</style>

</head>
<body>

<div class="container">

<h1>Admin Dashboard</h1>
<p class="subtitle">Welcome back, Admin 👋</p>

<div class="stats">

<div class="card">
<h2><?= $totalArticles ?></h2>
<p>📝 Total Articles</p>
</div>

<div class="card">
<h2><?= $publishedArticles ?></h2>
<p>✅ Published Articles</p>
</div>

<div class="card">
<h2><?= $draftArticles ?></h2>
<p>📄 Draft Articles</p>
</div>

</div>

<div class="actions">

<h2>Quick Actions</h2>

<div class="buttons">

<a href="add-article.php" class="btn">➕ Add Article</a>

<a href="articles.php" class="btn">📚 Manage Articles</a>

<a href="../index.php" class="btn website" target="_blank">🌐 View Website</a>

<a href="logout.php" class="btn logout">🚪 Logout</a>

</div>

</div>

</div>

</body>
</html>