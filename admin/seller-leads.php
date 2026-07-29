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

$totalLeads = $pdo->query("
    SELECT COUNT(*)
    FROM seller_leads
")->fetchColumn();

$newLeads = $pdo->query("
    SELECT COUNT(*)
    FROM seller_leads
    WHERE status='New'
")->fetchColumn();

$contactedLeads = $pdo->query("
    SELECT COUNT(*)
    FROM seller_leads
    WHERE status='Contacted'
")->fetchColumn();

$offerSentLeads = $pdo->query("
    SELECT COUNT(*)
    FROM seller_leads
    WHERE status='Offer Sent'
")->fetchColumn();

$closedLeads = $pdo->query("
    SELECT COUNT(*)
    FROM seller_leads
    WHERE status='Closed'
")->fetchColumn();

$notInterestedLeads = $pdo->query("
    SELECT COUNT(*)
    FROM seller_leads
    WHERE status='Not Interested'
")->fetchColumn();

/*==================================================
    Get Seller Leads
==================================================*/

$stmt = $pdo->query("
    SELECT *
    FROM seller_leads
    ORDER BY created_at DESC
");

$leads = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Seller Leads | Cash4MobileHomes Admin</title>

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

            Seller Leads

        </h1>

        <p>

            Manage, track and convert seller leads from one dashboard.

        </p>

    </div>

    <div class="topbar-right">

        <div class="user-profile">

            <div class="user-avatar">

                <i class="fa-solid fa-user"></i>

            </div>

            <div class="user-info">

                <strong>

                    Administrator

                </strong>

                <small>

                    Cash4MobileHomes

                </small>

            </div>

        </div>

    </div>

</header>
<!-- ==================================================
     Dashboard Statistics
================================================== -->

<section class="section">

    <div class="stats">

        <!-- Total -->

        <div class="card green">

            <div class="card-icon">

                <i class="fa-solid fa-house"></i>

            </div>

            <h2><?= $totalLeads ?></h2>

            <p>Total Leads</p>

        </div>

        <!-- New -->

        <div class="card blue">

            <div class="card-icon">

                <i class="fa-solid fa-circle-plus"></i>

            </div>

            <h2><?= $newLeads ?></h2>

            <p>New Leads</p>

        </div>

        <!-- Contacted -->

        <div class="card orange">

            <div class="card-icon">

                <i class="fa-solid fa-phone"></i>

            </div>

            <h2><?= $contactedLeads ?></h2>

            <p>Contacted</p>

        </div>

    

        <!-- Offer Sent -->

        <div class="card blue">

            <div class="card-icon">

                <i class="fa-solid fa-paper-plane"></i>

            </div>

            <h2><?= $offerSentLeads ?></h2>

            <p>Offer Sent</p>

        </div>

        <!-- Closed -->

        <div class="card red">

            <div class="card-icon">

                <i class="fa-solid fa-circle-check"></i>

            </div>

            <h2><?= $closedLeads ?></h2>

            <p>Closed</p>

        </div>

        <!-- Not Interested -->

        <div class="card orange">

            <div class="card-icon">

                <i class="fa-solid fa-ban"></i>

            </div>

            <h2><?= $notInterestedLeads ?></h2>

            <p>Not Interested</p>

        </div>

    </div>

</section>
<!-- ==================================================
     CRM Toolbar
================================================== -->

<section class="section">

    <div class="form-card">

        <div class="toolbar-header">

            <div>

                <h2>

                    Seller Lead Manager

                </h2>

                <p style="color:var(--muted);margin-top:5px;">

                    Search, filter, review and manage every seller lead from one dashboard.

                </p>

            </div>

            <div class="buttons">

                <button
                    type="button"
                    class="btn secondary"
                    id="refreshBtn">

                    <i class="fa-solid fa-rotate-right"></i>

                    Refresh

                </button>

                <button
                    type="button"
                    class="btn success"
                    id="exportBtn">

                    <i class="fa-solid fa-file-csv"></i>

                    Export CSV

                </button>

            </div>

        </div>

        <div
            class="form-grid"
            style="margin-top:30px;">

            <div class="form-group">

                <label>

                    Search Leads

                </label>

                <input
                    type="text"
                    id="searchLead"
                    placeholder="Search by name, email, phone, city or address...">

            </div>

            <div class="form-group">

                <label>

                    Filter Status

                </label>

                <select id="statusFilter">

                    <option value="">All Leads</option>

                    <option value="New">New</option>

                    <option value="Contacted">Contacted</option>

                    <option value="Offer Sent">Offer Sent</option>

                    <option value="Closed">Closed</option>

                    <option value="Not Interested">Not Interested</option>

                </select>

            </div>

        </div>

    </div>

</section>
<!-- ==================================================
     Seller Leads Table
================================================== -->

<section class="section">

    <div class="table-wrapper">

        <table id="sellerTable">

            <thead>

                <tr>

                    <th>Lead</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Property</th>
                    <th>Submitted</th>
                    <th>Status</th>
                    <th style="width:170px;">Actions</th>

                </tr>

            </thead>

            <tbody>

                <?php if(count($leads) > 0): ?>

                    <?php foreach($leads as $lead): ?>

                    <?php

                        $statusClass = "info";

                        switch($lead['status']){

                        

                            case "Offer Sent":
                                $statusClass = "primary";
                                break;

                            case "Closed":
                                $statusClass = "success";
                                break;

                            case "Not Interested":
                                $statusClass = "danger";
                                break;

                            default:
                                $statusClass = "info";

                        }

                    ?>

                    <tr
                        data-status="<?= htmlspecialchars($lead['status']) ?>"
                        data-search="<?= strtolower(htmlspecialchars(
                            $lead['first_name']." ".
                            $lead['last_name']." ".
                            $lead['email']." ".
                            $lead['phone']." ".
                            $lead['city']." ".
                            $lead['state']." ".
                            $lead['property_address']
                        )) ?>">

                        <!-- Lead Badge -->

                        <td>

                            <?php if($lead['is_read']==0): ?>

                                <span class="badge info">

                                    NEW

                                </span>

                            <?php else: ?>

                                <span class="badge">

                                    Viewed

                                </span>

                            <?php endif; ?>

                        </td>

                        <!-- Name -->

                        <td>

                            <strong>

                                <?= htmlspecialchars($lead['first_name']) ?>

                                <?= htmlspecialchars($lead['last_name']) ?>

                            </strong>

                            <br>

                            <small>

                                <?= htmlspecialchars($lead['email']) ?>

                            </small>

                        </td>

                        <!-- Phone -->

                        <td>

                            <?= htmlspecialchars($lead['phone']) ?>

                        </td>

                        <!-- Property -->

                        <td>

                            <?= htmlspecialchars($lead['property_address']) ?>

                            <br>

                            <small>

                                <?= htmlspecialchars($lead['city']) ?>,

                                <?= htmlspecialchars($lead['state']) ?>

                            </small>

                        </td>

                        <!-- Submitted -->

                        <td>

                            <?= date("M d, Y",strtotime($lead['created_at'])) ?>

                            <br>

                            <small>

                                <?= date("h:i A",strtotime($lead['created_at'])) ?>

                            </small>

                        </td>

                        <!-- Status -->

                        <td>

                            <span class="badge <?= $statusClass ?>">

                                <?= htmlspecialchars($lead['status']) ?>

                            </span>

                        </td>

                        <!-- Actions -->

                        <td>

                            <div class="action-buttons">

                                <button
                                    class="action-btn view openLeadBtn"
                                    data-id="<?= $lead['id'] ?>"
                                    title="Open Lead">

                                    <i class="fa-solid fa-eye"></i>

                                </button>

                                <button
                                    class="action-btn edit statusBtn"
                                    data-id="<?= $lead['id'] ?>"
                                    title="Update Status">

                                    <i class="fa-solid fa-flag"></i>

                                </button>

                                <button
                                    class="action-btn delete deleteLeadBtn"
                                    data-id="<?= $lead['id'] ?>"
                                    title="Delete Lead">

                                    <i class="fa-solid fa-trash"></i>

                                </button>

                            </div>

                        </td>

                    </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="7" style="text-align:center;padding:40px;">

                            <i class="fa-solid fa-inbox"></i>

                            <br><br>

                            No seller leads found.

                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</section>
<!-- ==================================================
     Seller Lead Drawer
================================================== -->

<div
    id="drawerOverlay"
    class="drawer-overlay">
</div>

<div
    id="leadDrawer"
    class="lead-drawer">

    <div class="lead-drawer-header">

        <div>

            <h2>

                Seller Lead Details

            </h2>

            <p>

                Review and update this lead.

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
        id="leadDrawerContent"
        class="lead-drawer-body">

        <div
            class="drawer-placeholder">

            <i
                class="fa-solid fa-address-card"
                style="font-size:48px;color:#D1D5DB;"></i>

            <h3 style="margin-top:20px;">

                Select a Seller Lead

            </h3>

            <p style="color:#6B7280;">

                Click the eye icon to view the complete lead information.

            </p>

        </div>

    </div>

</div>
</main>

</div>
<div id="statusPopover" class="status-popover">

    <h4>Update Status</h4>

    <input type="hidden" id="statusLeadId">

    <select id="quickStatus">

        <option>New</option>
        <option>Contacted</option>
        <option>Offer Sent</option>
        <option>Closed</option>
        <option>Not Interested</option>

    </select>

    <button
        class="btn success"
        id="saveStatusBtn">

        Save Changes

    </button>

</div>

<script src="js/seller-leads.js"></script>

</body>
</html>