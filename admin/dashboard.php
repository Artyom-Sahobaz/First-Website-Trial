<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require_once("../includes/config.php");

/*=========================================
  Dashboard Statistics
=========================================*/

// Seller Leads
$sellerCount = $pdo->query("
    SELECT COUNT(*) 
    FROM seller_leads
")->fetchColumn();

// Buyer Leads
$buyerCount = $pdo->query("
    SELECT COUNT(*) 
    FROM buyer_leads
")->fetchColumn();

// Total Articles
$totalArticles = $pdo->query("
    SELECT COUNT(*)
    FROM articles
")->fetchColumn();

// Published Articles
$publishedArticles = $pdo->query("
    SELECT COUNT(*)
    FROM articles
    WHERE status='Published'
")->fetchColumn();

// Draft Articles
$draftArticles = $pdo->query("
    SELECT COUNT(*)
    FROM articles
    WHERE status='Draft'
")->fetchColumn();

?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Dashboard | Cash4MobileHomes Admin</title>

<link rel="stylesheet"
      href="css/admin.css">

<link rel="preconnect"
      href="https://fonts.googleapis.com">

<link rel="preconnect"
      href="https://fonts.gstatic.com"
      crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<div class="admin-layout">

    <!-- Sidebar -->
    <?php include("sidebar.php"); ?>

    <!-- Main Content -->
    <main class="main-content">

        <!-- Top Navigation -->
        <header class="topbar">

            <div>

                <h1 class="page-title">
                    Dashboard
                </h1>

                <p>
                    Welcome back! Here's what's happening today.
                </p>

            </div>

            <div class="topbar-right">

            

                <div class="user-profile">

                    <div class="user-avatar">

                        <i class="fa-solid fa-user"></i>

                    </div>

                    <div class="user-info">

                        <strong>Administrator</strong>

                        <small>Cash4MobileHomes</small>

                    </div>

                </div>

            </div>

        </header>

        <!-- Welcome Section -->

        <section class="section">

            <div class="form-card">

                <div class="form-title">

                    <h2>
                        Welcome Back 👋
                    </h2>

                    <p>

                        Manage seller leads, buyer leads, blog articles,
                        and your website from one clean dashboard.

                    </p>

                </div>
                                <!-- Dashboard Statistics -->

                <div class="stats">

                    <!-- Seller Leads -->

                    <div class="card green clickable-card"
                         onclick="window.location='seller-leads.php'">

                        <div class="card-icon">
                            <i class="fa-solid fa-house"></i>
                        </div>

                        <h2><?= $sellerCount ?></h2>

                        <p>Seller Leads</p>

                        <div class="card-footer">

                            <span>

                                <i class="fa-solid fa-arrow-trend-up"></i>

                                Active Leads

                            </span>

                        </div>

                    </div>

                    <!-- Buyer Leads -->

                    <div class="card blue clickable-card"
                         onclick="window.location='buyer-leads.php'">

                        <div class="card-icon">
                            <i class="fa-solid fa-users"></i>
                        </div>

                        <h2><?= $buyerCount ?></h2>

                        <p>Buyer Leads</p>

                        <div class="card-footer">

                            <span>

                                <i class="fa-solid fa-user-check"></i>

                                Registered Buyers

                            </span>

                        </div>

                    </div>

                    <!-- Total Articles -->

                    <div class="card orange clickable-card"
                         onclick="window.location='articles.php'">

                        <div class="card-icon">
                            <i class="fa-solid fa-newspaper"></i>
                        </div>

                        <h2><?= $totalArticles ?></h2>

                        <p>Total Articles</p>

                        <div class="card-footer">

                            <span>

                                <i class="fa-solid fa-pen"></i>

                                Content Library

                            </span>

                        </div>

                    </div>

                    <!-- Published -->

                    <div class="card clickable-card"
                         onclick="window.location='articles.php?status=Published'">

                        <div class="card-icon">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>

                        <h2><?= $publishedArticles ?></h2>

                        <p>Published Articles</p>

                        <div class="card-footer">

                            <span>

                                <i class="fa-solid fa-globe"></i>

                                Live Website

                            </span>

                        </div>

                    </div>

                    <!-- Draft -->

                    <div class="card red clickable-card"
                         onclick="window.location='articles.php?status=Draft'">

                        <div class="card-icon">
                            <i class="fa-solid fa-file-pen"></i>
                        </div>

                        <h2><?= $draftArticles ?></h2>

                        <p>Draft Articles</p>

                        <div class="card-footer">

                            <span>

                                <i class="fa-solid fa-clock"></i>

                                Waiting To Publish

                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </section>
                <!-- Quick Actions -->

        <section class="section">

            <h2 class="section-title">

                Quick Actions

            </h2>

            <div class="buttons">

                <a href="seller-leads.php" class="btn">

                    <i class="fa-solid fa-house"></i>

                    Seller Leads

                </a>

                <a href="buyer-leads.php" class="btn secondary">

                    <i class="fa-solid fa-users"></i>

                    Buyer Leads

                </a>

                <a href="articles.php" class="btn success">

                    <i class="fa-solid fa-newspaper"></i>

                    Manage Articles

                </a>

                <a href="article-add.php" class="btn">

                    <i class="fa-solid fa-plus"></i>

                    Add Article

                </a>

                <a href="../index.php"
                   target="_blank"
                   class="btn secondary">

                    <i class="fa-solid fa-globe"></i>

                    View Website

                </a>

                <a href="logout.php"
                   class="btn danger">

                    <i class="fa-solid fa-right-from-bracket"></i>

                    Logout

                </a>

            </div>

        </section>

        <!-- Dashboard Overview -->

        <section class="section">

            <div class="form-grid">

                <!-- Website Overview -->

                <div class="form-card">

                    <div class="form-title">

                        <h2>

                            Website Overview

                        </h2>

                        <p>

                            Current content and lead statistics.

                        </p>

                    </div>

                    <table>

                        <tbody>

                            <tr>

                                <td><strong>Seller Leads</strong></td>

                                <td><?= $sellerCount ?></td>

                            </tr>

                            <tr>

                                <td><strong>Buyer Leads</strong></td>

                                <td><?= $buyerCount ?></td>

                            </tr>

                            <tr>

                                <td><strong>Total Articles</strong></td>

                                <td><?= $totalArticles ?></td>

                            </tr>

                            <tr>

                                <td><strong>Published</strong></td>

                                <td>

                                    <span class="badge success">

                                        <?= $publishedArticles ?>

                                    </span>

                                </td>

                            </tr>

                            <tr>

                                <td><strong>Drafts</strong></td>

                                <td>

                                    <span class="badge warning">

                                        <?= $draftArticles ?>

                                    </span>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

                <!-- Admin Information -->

                <div class="form-card">

                    <div class="form-title">

                        <h2>

                            Admin Panel

                        </h2>

                        <p>

                            Quick information about your website.

                        </p>

                    </div>

                    <table>

                        <tbody>

                            <tr>

                                <td><strong>CMS Version</strong></td>

                                <td>1.0</td>

                            </tr>

                            <tr>

                                <td><strong>Environment</strong></td>

                                <td>Production</td>

                            </tr>

                            <tr>

                                <td><strong>Database</strong></td>

                                <td>Connected</td>

                            </tr>

                            <tr>

                                <td><strong>PHP</strong></td>

                                <td><?= phpversion(); ?></td>

                            </tr>

                            <tr>

                                <td><strong>Status</strong></td>

                                <td>

                                    <span class="badge success">

                                        Online

                                    </span>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </section>
                <!-- Recent Activity & System Status -->

        <section class="section">

            <div class="form-grid">

                <!-- Recent Activity -->

                <div class="form-card">

                    <div class="form-title">

                        <h2>

                            Recent Activity

                        </h2>

                        <p>

                            A quick overview of your admin panel.

                        </p>

                    </div>

                    <table>

                        <tbody>

                            <tr>

                                <td>
                                    <i class="fa-solid fa-house"
                                       style="color:#5AAE8C;"></i>
                                    Seller Leads
                                </td>

                                <td><?= $sellerCount ?></td>

                            </tr>

                            <tr>

                                <td>
                                    <i class="fa-solid fa-users"
                                       style="color:#77AEE8;"></i>
                                    Buyer Leads
                                </td>

                                <td><?= $buyerCount ?></td>

                            </tr>

                            <tr>

                                <td>
                                    <i class="fa-solid fa-newspaper"
                                       style="color:#F4A340;"></i>
                                    Articles
                                </td>

                                <td><?= $totalArticles ?></td>

                            </tr>

                            <tr>

                                <td>
                                    <i class="fa-solid fa-circle-check"
                                       style="color:#5AAE8C;"></i>
                                    Published
                                </td>

                                <td><?= $publishedArticles ?></td>

                            </tr>

                            <tr>

                                <td>
                                    <i class="fa-solid fa-file-pen"
                                       style="color:#E25C5C;"></i>
                                    Drafts
                                </td>

                                <td><?= $draftArticles ?></td>

                            </tr>

                        </tbody>

                    </table>

                </div>

                <!-- Tips -->

                <div class="form-card">

                    <div class="form-title">

                        <h2>

                            Dashboard Tips

                        </h2>

                        <p>

                            Helpful reminders for managing your website.

                        </p>

                    </div>

                    <div class="alert success">

                        <i class="fa-solid fa-circle-check"></i>

                        Your website is connected successfully.

                    </div>

                    <div class="alert info">

                        <i class="fa-solid fa-lightbulb"></i>

                        Keep publishing fresh articles to improve SEO.

                    </div>

                    <div class="alert warning">

                        <i class="fa-solid fa-pen"></i>

                        Review draft articles before publishing.

                    </div>

                    <div class="alert success">

                        <i class="fa-solid fa-shield-halved"></i>

                        Remember to log out after finishing your work.

                    </div>

                </div>

            </div>

        </section>

        <!-- Footer -->

        <footer
            style="
            margin-top:60px;
            text-align:center;
            color:#7A8897;
            font-size:14px;
            padding:25px 0;">

            © <?= date('Y'); ?>

            Cash4MobileHomes USA

            Admin Dashboard

        </footer>

    </main>

</div>

</body>

</html>