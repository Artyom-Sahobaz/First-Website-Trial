<?php

session_start();

if (!isset($_SESSION['admin'])) {
    http_response_code(401);

    echo json_encode([
        "success" => false,
        "message" => "Unauthorized."
    ]);

    exit;
}

require_once("../../includes/config.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    echo json_encode([
        "success" => false,
        "message" => "Invalid request."
    ]);

    exit;
}

/*==================================================
  Get POST Data
==================================================*/

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

$status = trim($_POST['status'] ?? '');

$notes = trim($_POST['notes'] ?? '');

/*==================================================
  Validate
==================================================*/

$allowedStatus = [

    "New",
    "Contacted",
    "Offer Sent",
    "Closed",
    "Not Interested"

];

if ($id <= 0) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid Lead ID."
    ]);

    exit;
}

if (!in_array($status, $allowedStatus, true)) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid Status."
    ]);

    exit;
}

/*==================================================
  Check Lead Exists
==================================================*/

$check = $pdo->prepare("
    SELECT id
    FROM seller_leads
    WHERE id=?
");

$check->execute([$id]);

if (!$check->fetch()) {

    echo json_encode([
        "success" => false,
        "message" => "Lead not found."
    ]);

    exit;
}

/*==================================================
  Last Contacted
==================================================*/

$lastContacted = null;

if ($status != "New") {

    $lastContacted = date("Y-m-d H:i:s");

}

/*==================================================
  Update Lead
==================================================*/

$update = $pdo->prepare("
UPDATE seller_leads
SET
    status = ?,
    notes = ?,
    is_read = 1,
    last_contacted = ?
WHERE id = ?
");

$success = $update->execute([

$status,

$notes,

$lastContacted,

$id

]);

if (!$success) {

    echo json_encode([

        "success"=>false,

        "message"=>"Database update failed."

    ]);

    exit;

}

/*==================================================
  Success
==================================================*/

echo json_encode([

    "success"=>true,

    "message"=>"Lead updated successfully.",

    "status"=>$status,

    "last_contacted"=>$lastContacted

]);

exit;