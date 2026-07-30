<?php

session_start();

if (!isset($_SESSION['admin'])) {

    header("Location: login.php");
    exit;

}

require_once("../includes/config.php");

/*==================================================
    Dashboard Statistics
==================================================*/

$totalMessages = $pdo->query("
    SELECT COUNT(*)
    FROM contact_messages
")->fetchColumn();

$unreadMessages = $pdo->query("
    SELECT COUNT(*)
    FROM contact_messages
    WHERE is_read = 0
")->fetchColumn();

$readMessages = $pdo->query("
    SELECT COUNT(*)
    FROM contact_messages
    WHERE is_read = 1
")->fetchColumn();

$todayMessages = $pdo->query("
    SELECT COUNT(*)
    FROM contact_messages
    WHERE DATE(created_at)=CURDATE()
")->fetchColumn();

/*==================================================
    Pagination
==================================================*/

$perPage = 25;

$page = isset($_GET['page'])
    ? max(1,(int)$_GET['page'])
    : 1;

$totalRows = $pdo->query("
    SELECT COUNT(*)
    FROM contact_messages
")->fetchColumn();

$totalPages = max(1,ceil($totalRows/$perPage));

$offset = ($page-1)*$perPage;

$stmt = $pdo->prepare("
    SELECT *
    FROM contact_messages
    ORDER BY created_at DESC
    LIMIT :limit OFFSET :offset
");

$stmt->bindValue(":limit",$perPage,PDO::PARAM_INT);
$stmt->bindValue(":offset",$offset,PDO::PARAM_INT);

$stmt->execute();

$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

$showingFrom = $totalRows>0 ? $offset+1 : 0;
$showingTo   = min($offset+$perPage,$totalRows);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Contact Messages | Cash4MobileHomes Admin</title>

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
Contact Messages
</h1>

<p>
Review, organize and manage every website contact message.
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

<section class="section">

<div class="stats">

<div class="card green">

<div class="card-icon">
<i class="fa-solid fa-envelope"></i>
</div>

<h2><?= $totalMessages ?></h2>

<p>Total Messages</p>

</div>

<div class="card blue">

<div class="card-icon">
<i class="fa-solid fa-envelope-open"></i>
</div>

<h2><?= $unreadMessages ?></h2>

<p>Unread</p>

</div>

<div class="card orange">

<div class="card-icon">
<i class="fa-solid fa-check"></i>
</div>

<h2><?= $readMessages ?></h2>

<p>Read</p>

</div>

<div class="card red">

<div class="card-icon">
<i class="fa-solid fa-calendar-day"></i>
</div>

<h2><?= $todayMessages ?></h2>

<p>Today</p>

</div>

</div>

</section>
<!-- ==================================================
     Toolbar
================================================== -->

<section class="section">

<div class="form-card">

<div class="toolbar-header">

<div class="toolbar-title">

<h2>Contact Message Manager</h2>

<p>

Search, review and manage every contact message from one dashboard.

</p>

</div>

<div class="toolbar-actions">

<button
type="button"
class="btn secondary"
id="refreshBtn">

<i class="fa-solid fa-rotate-right"></i>

Refresh

</button>

</div>

</div>

<div class="form-grid" style="margin-top:30px;">

<div class="form-group">

<label>Search Messages</label>

<input
type="text"
id="searchMessage"
placeholder="Search by name, email or message...">

</div>

</div>

</div>

</section>

<!-- ==================================================
     Contact Messages Table
================================================== -->

<section class="section">

<div class="table-wrapper">

<table id="contactTable">

<thead>

<tr>

<th>Message</th>
<th>Name</th>
<th>Email</th>
<th>Submitted</th>
<th>Status</th>
<th style="width:170px;">Actions</th>

</tr>

</thead>

<tbody>

<?php if(count($messages)>0): ?>

<?php foreach($messages as $message): ?>

<tr
data-read="<?= $message['is_read'] ?>"
data-status="<?= $message['is_read'] ? 'Read' : 'Unread' ?>"

data-search="<?= strtolower(htmlspecialchars(
$message['full_name']." ".
$message['email']." ".
$message['message']
)) ?>">

<td>

<?php if($message['is_read']==0): ?>

<span class="badge info">

NEW

</span>

<?php else: ?>

<span class="badge">

Viewed

</span>

<?php endif; ?>

</td>

<td>

<strong>

<?= htmlspecialchars($message['full_name']) ?>

</strong>

</td>

<td>

<?= htmlspecialchars($message['email']) ?>

</td>

<td>

<?= date("M d, Y",strtotime($message['created_at'])) ?>

<br>

<small>

<?= date("h:i A",strtotime($message['created_at'])) ?>

</small>

</td>

<td>

<?php if($message['is_read']): ?>

<span class="badge success">

Read

</span>

<?php else: ?>

<span class="badge warning">

Unread

</span>

<?php endif; ?>

</td>

<td>

<div class="action-buttons">

<button

class="action-btn view openContactBtn"

data-id="<?= $message['id'] ?>"

title="View Message">

<i class="fa-solid fa-eye"></i>

</button>

<button

class="action-btn delete deleteContactBtn"

data-id="<?= $message['id'] ?>"

title="Delete Message">

<i class="fa-solid fa-trash"></i>

</button>

</div>

</td>

</tr>

<?php endforeach; ?>

<?php else: ?>

<tr>

<td colspan="6" style="text-align:center;padding:40px;">

<i class="fa-solid fa-envelope-open-text"></i>

<br><br>

No contact messages found.

</td>

</tr>

<?php endif; ?>

</tbody>

</table>

</div>
<!-- ==================================================
     Pagination
================================================== -->

<div class="pagination-wrapper">

    <div class="pagination-info">

        Showing

        <strong><?= $showingFrom ?></strong>

        -

        <strong><?= $showingTo ?></strong>

        of

        <strong><?= $totalRows ?></strong>

        contact messages

    </div>

    <div class="pagination">

        <?php if($page > 1): ?>

            <a
                class="page-btn"
                href="?page=<?= $page-1 ?>">

                <i class="fa-solid fa-angle-left"></i>

            </a>

        <?php endif; ?>

        <?php for($i=1;$i<=$totalPages;$i++): ?>

            <a
                href="?page=<?= $i ?>"
                class="page-btn <?= $i==$page ? 'active' : '' ?>">

                <?= $i ?>

            </a>

        <?php endfor; ?>

        <?php if($page < $totalPages): ?>

            <a
                class="page-btn"
                href="?page=<?= $page+1 ?>">

                <i class="fa-solid fa-angle-right"></i>

            </a>

        <?php endif; ?>

    </div>

</div>

</section>

<!-- ==================================================
     Contact Drawer
================================================== -->

<div
    id="drawerOverlay"
    class="drawer-overlay">
</div>

<div
    id="contactDrawer"
    class="lead-drawer">

    <div class="lead-drawer-header">

        <div>

            <h2>

                Contact Message

            </h2>

            <p>

                Review and manage this contact message.

            </p>

        </div>

        <button
            type="button"
            id="closeDrawer"
            class="drawer-close">

            <i class="fa-solid fa-xmark"></i>

        </button>

    </div>

    <div
        id="contactDrawerContent"
        class="lead-drawer-body">

        <div class="drawer-placeholder">

            <i
                class="fa-solid fa-envelope-open-text"
                style="font-size:48px;color:#D1D5DB;"></i>

            <h3 style="margin-top:20px;">

                Select a Contact Message

            </h3>

            <p style="color:#6B7280;">

                Click the eye icon to view the complete message.

            </p>

        </div>

    </div>

</div>

</main>

</div>

<script src="js/contact-messages.js"></script>

</body>

</html>