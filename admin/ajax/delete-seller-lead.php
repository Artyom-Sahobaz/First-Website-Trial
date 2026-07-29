<?php

session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['admin'])) {

    http_response_code(401);

    echo json_encode([
        "success" => false,
        "message" => "Unauthorized."
    ]);

    exit;
}

require_once("../../includes/config.php");

/*==================================================
  Only POST Requests
==================================================*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    http_response_code(405);

    echo json_encode([
        "success" => false,
        "message" => "Invalid request method."
    ]);

    exit;
}

/*==================================================
  Get Lead ID
==================================================*/

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid Lead ID."
    ]);

    exit;
}

/*==================================================
  Check Lead Exists
==================================================*/

$check = $pdo->prepare("
    SELECT
        id,
        first_name,
        last_name
    FROM seller_leads
    WHERE id = ?
");

$check->execute([$id]);

$lead = $check->fetch(PDO::FETCH_ASSOC);

if (!$lead) {

    echo json_encode([
        "success" => false,
        "message" => "Lead not found."
    ]);

    exit;
}

/*==================================================
  Delete Lead
==================================================*/

$delete = $pdo->prepare("
    DELETE
    FROM seller_leads
    WHERE id = ?
");

$success = $delete->execute([$id]);

if (!$success) {

    echo json_encode([
        "success" => false,
        "message" => "Unable to delete lead."
    ]);

    exit;
}

/*==================================================
  Success Response
==================================================*/

echo json_encode([

    "success" => true,

    "message" => "Lead deleted successfully.",

    "deleted_id" => $id,

    "lead_name" => trim(
        $lead['first_name'] . ' ' . $lead['last_name']
    )

]);

exit;