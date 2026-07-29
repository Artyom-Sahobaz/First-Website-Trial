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

/*
|--------------------------------------------------------------------------
| Get the article first
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("SELECT featured_image FROM articles WHERE id = ?");
$stmt->execute([$id]);

$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    die("Article not found.");
}

/*
|--------------------------------------------------------------------------
| Delete the image from images/uploads
|--------------------------------------------------------------------------
*/

if (!empty($article['featured_image'])) {

    $imagePath = "../" . $article['featured_image'];

    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
}

/*
|--------------------------------------------------------------------------
| Delete the article
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("DELETE FROM articles WHERE id = ?");
$stmt->execute([$id]);

header("Location: articles.php");
exit;