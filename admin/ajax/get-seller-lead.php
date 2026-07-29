<?php

session_start();

if (!isset($_SESSION['admin'])) {
    exit("Unauthorized");
}

require_once("../../includes/config.php");

if (!isset($_GET['id'])) {
    exit("Invalid Request");
}

$id = (int)$_GET['id'];

/* Mark lead as read */

$update = $pdo->prepare("
    UPDATE seller_leads
    SET is_read = 1
    WHERE id = ?
");

$update->execute([$id]);

/* Get lead */

$stmt = $pdo->prepare("
    SELECT *
    FROM seller_leads
    WHERE id = ?
");

$stmt->execute([$id]);

$lead = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$lead) {

    exit("Lead not found.");

}

?>

<div class="lead-details">

    <div class="form-grid">

        <div class="form-group">

            <label>Full Name</label>

            <input
                type="text"
                value="<?= htmlspecialchars(($lead['first_name'] ?? '') . ' ' . ($lead['last_name'] ?? '')) ?>"
                readonly>

        </div>

        <div class="form-group">

            <label>Phone</label>

            <input
                type="text"
                value="<?= htmlspecialchars($lead['phone'] ?? '') ?>"
                readonly>

        </div>

        <div class="form-group">

            <label>Email</label>

            <input
                type="text"
                value="<?= htmlspecialchars($lead['email'] ?? '') ?>"
                readonly>

        </div>

        <div class="form-group">

            <label>Status</label>

            <select id="leadStatus">

                <?php

                $statuses = [
                    "New",
                    "Contacted",
                    "Offer Sent",
                    "Closed",
                    "Not Interested"
                ];

                foreach($statuses as $status){

                    $selected = ($lead['status']==$status)
                        ? "selected"
                        : "";

                    echo "<option $selected>$status</option>";

                }

                ?>

            </select>

        </div>

        <div class="form-group full">

            <label>Property Address</label>

            <input
                type="text"
                value="<?= htmlspecialchars($lead['property_address']) ?>"
                readonly>

        </div>

        <div class="form-group">

            <label>City</label>

            <input
                type="text"
                value="<?= htmlspecialchars($lead['city'] ?? '') ?>"
                readonly>

        </div>

        <div class="form-group">

            <label>State</label>

            <input
                type="text"
                value="<?= htmlspecialchars($lead['state'] ?? '') ?>"
                readonly>

        </div>

        <div class="form-group">

            <label>ZIP</label>

            <input
                type="text"
                value="<?= htmlspecialchars($lead['zip_code'] ?? '') ?>"
                readonly>

        </div>

        <div class="form-group">

            <label>Home Type</label>

            <input
                type="text"
                value="<?= htmlspecialchars($lead['home_type'] ?? '') ?>"
                readonly>

        </div>

        <div class="form-group">

            <label>Bedrooms</label>

            <input
                type="text"
                value="<?= htmlspecialchars($lead['bedrooms'] ?? '') ?>"
                readonly>

        </div>

        <div class="form-group">

            <label>Bathrooms</label>

            <input
                type="text"
                value="<?= htmlspecialchars($lead['bathrooms'] ?? '') ?>"
                readonly>

        </div>

        <div class="form-group">

            <label>Asking Price</label>

            <input
                type="text"
                value="<?= htmlspecialchars($lead['asking_price'] ?? '') ?>"
                readonly>

        </div>

        <div class="form-group full">

            <label>Message</label>

            <textarea readonly><?= htmlspecialchars($lead['message'] ?? '') ?></textarea>

        </div>

        <div class="form-group full">

            <label>Internal Notes</label>

            <textarea id="leadNotes"><?= htmlspecialchars($lead['notes'] ?? '') ?></textarea>

        </div>

    </div>

</div>
<hr style="margin:35px 0;border:none;border-top:1px solid #E5E7EB;">

<input
    type="hidden"
    id="leadId"
    value="<?= $lead['id'] ?>">

<div class="form-grid">

    <div class="form-group">

        <label>

            Submitted

        </label>

        <input
            type="text"
            value="<?= date('F d, Y h:i A', strtotime($lead['created_at'])) ?>"
            readonly>

    </div>

    <div class="form-group">

        <label>

            Last Contacted

        </label>

        <input
            type="text"
            value="<?= !empty($lead['last_contacted']) ? date('F d, Y h:i A', strtotime($lead['last_contacted'])) : 'Never' ?>"
            readonly>

    </div>

</div>

<div
    id="leadResponse"
    style="margin-top:20px;">
</div>

<div
    class="form-actions">

    <button
        type="button"
        class="btn btn-save"
        id="saveLeadBtn">

        <i class="fa-solid fa-floppy-disk"></i>

        Save Changes

    </button>

    <button
        type="button"
        class="btn danger"
        id="deleteLeadBtn">

        <i class="fa-solid fa-trash"></i>

        Delete Lead

    </button>

</div>
