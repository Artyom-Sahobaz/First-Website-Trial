<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php

$siteName = "Cash4MobileHomes";
$siteUrl = "https://cash4mobilehomes.com"; // Change this when your domain is live

$title = $pageTitle ?? $siteName;

$description = $metaDescription ??
    "Cash4MobileHomes helps homeowners buy and sell mobile homes quickly with fair cash offers and helpful resources.";

$keywords = $metaKeywords ??
    "mobile homes, sell mobile home, buy mobile home";

$image = $metaImage ??
    $siteUrl . "/images/logo.png";

$canonical = $canonicalUrl ??
    $siteUrl . $_SERVER['REQUEST_URI'];

?>

<title><?= htmlspecialchars($title); ?></title>

<meta name="description" content="<?= htmlspecialchars($description); ?>">

<meta name="keywords" content="<?= htmlspecialchars($keywords); ?>">

<link rel="canonical" href="<?= htmlspecialchars($canonical); ?>">

<!-- Open Graph -->

<meta property="og:type" content="website">

<meta property="og:site_name" content="<?= $siteName; ?>">

<meta property="og:title" content="<?= htmlspecialchars($title); ?>">

<meta property="og:description" content="<?= htmlspecialchars($description); ?>">

<meta property="og:image" content="<?= htmlspecialchars($image); ?>">

<meta property="og:url" content="<?= htmlspecialchars($canonical); ?>">

<!-- Twitter -->

<meta name="twitter:card" content="summary_large_image">

<meta name="twitter:title" content="<?= htmlspecialchars($title); ?>">

<meta name="twitter:description" content="<?= htmlspecialchars($description); ?>">

<meta name="twitter:image" content="<?= htmlspecialchars($image); ?>">

<link rel="stylesheet" href="css/style.css">

<?php if(isset($schemaData)): ?>

<script type="application/ld+json">

<?= json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); ?>

</script>

<?php endif; ?>

</head>

<body>
    <header class="header">

      <div class="container">

        <a href="index.php" class="logo">
            <span class="green-text">Cash4Mobile</span><span class="blue-text">Homes</span>
        </a>

        <nav class="nav">

    <button class="menu-toggle" id="menuToggle">
        ☰
    </button>

    <ul class="nav-links" id="navLinks">

        <li><a href="index.php">Home</a></li>
        <li><a href="index.php#how-it-works">How It Works</a></li>
        <li><a href="index.php#seller-form">Sell</a></li>
        <li><a href="index.php#buy">Buy</a></li>
        <li><a href="resources.php">Resources</a></li>
        <li><a href="index.php#contact">Contact Us</a></li>

    </ul>

</nav>

      </div>

    </header>