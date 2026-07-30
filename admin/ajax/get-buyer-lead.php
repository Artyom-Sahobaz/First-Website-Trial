<?php
session_start();
if (!isset($_SESSION['admin'])) {
    exit("Unauthorized");
}

require_once("../../includes/config.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    exit("Invalid Buyer Lead.");
}

$id = (int) $_GET['id'];

/* Mark as Read */

$pdo->prepare("
    UPDATE buyer_leads
    SET is_read = 1
    WHERE id = ?
")->execute([$id]);

/* Load Buyer */

$stmt = $pdo->prepare("
    SELECT *
    FROM buyer_leads
    WHERE id = ?
");

$stmt->execute([$id]);

$lead = $stmt->fetch(PDO::FETCH_ASSOC);
$lead['status'] = $lead['status'] ?? '';
$lead['notes'] = $lead['notes'] ?? '';
$lead['message'] = $lead['message'] ?? '';
$lead['full_name'] = $lead['full_name'] ?? '';
$lead['email'] = $lead['email'] ?? '';
$lead['phone'] = $lead['phone'] ?? '';
$lead['property_type'] = $lead['property_type'] ?? '';
$lead['preferred_location'] = $lead['preferred_location'] ?? '';
$lead['budget'] = $lead['budget'] ?? '';

if (!$lead) {
    exit("Buyer lead not found.");
}
?>

<input type="hidden" id="leadId" value="<?= $lead['id'] ?>">

<div class="drawer-grid">

    <div class="drawer-group">
        <label>Full Name</label>
        <input type="text"
               value="<?= htmlspecialchars($lead['full_name'] ?? '') ?>"
               readonly>
    </div>

    <div class="drawer-group">
        <label>Email</label>
        <input type="text"
               value="<?= htmlspecialchars($lead['email'] ?? '') ?>"
               readonly>
    </div>

    <div class="drawer-group">
        <label>Phone</label>
        <input type="text"
               value="<?= htmlspecialchars($lead['phone'] ?? '') ?>"
               readonly>
    </div>

    <div class="drawer-group">
        <label>Property Type</label>
        <input type="text"
               value="<?= htmlspecialchars($lead['property_type'] ?? '') ?>"
               readonly>
    </div>

    <div class="drawer-group">
        <label>Preferred Location</label>
        <input type="text"
               value="<?= htmlspecialchars($lead['preferred_location'] ?? '') ?>"
               readonly>
    </div>

    <div class="drawer-group">
        <label>Budget</label>
        <input type="text"
               value="<?= htmlspecialchars($lead['budget'] ?? '') ?>"
               readonly>
    </div>

    <div class="drawer-group drawer-full">
        <label>Message</label>
        <textarea rows="5" readonly><?= htmlspecialchars($lead['message'] ?? '') ?></textarea>
    </div>

    <div class="drawer-group">
        <label>Status</label>

        <select id="leadStatus">

            <option <?= $lead['status']=="New" ? "selected":"" ?>>New</option>
            <option <?= $lead['status']=="Contacted" ? "selected":"" ?>>Contacted</option>
            <option <?= $lead['status']=="Offer Sent" ? "selected":"" ?>>Offer Sent</option>
            <option <?= $lead['status']=="Closed" ? "selected":"" ?>>Closed</option>
            <option <?= $lead['status']=="Not Interested" ? "selected":"" ?>>Not Interested</option>

        </select>
    </div>

    <div class="drawer-group drawer-full">

        <label>Admin Notes</label>

        <textarea
    id="leadNotes"
    rows="5"><?= htmlspecialchars($lead['notes'] ?? '') ?></textarea>

    </div>

</div>

<div class="drawer-actions">

    <button
        class="btn success"
        id="saveLeadBtn">

        <i class="fa-solid fa-floppy-disk"></i>

        Save Changes

    </button>

    <button
        class="btn danger"
        id="deleteLeadBtn">

        <i class="fa-solid fa-trash"></i>

        Delete Lead

    </button>

</div>