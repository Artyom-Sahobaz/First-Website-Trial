<?php
session_start();

if (!isset($_SESSION['admin'])) {
    http_response_code(401);
    exit("Unauthorized");
}

require_once("../../includes/config.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit("Invalid request.");
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$status = trim($_POST['status'] ?? '');
$notes = trim($_POST['notes'] ?? '');

$allowedStatuses = [
    "New",
    "Contacted",
    "Offer Sent",
    "Closed",
    "Not Interested"
];

if ($id <= 0) {
    http_response_code(400);
    exit("Invalid lead ID.");
}

if (!in_array($status, $allowedStatuses, true)) {
    http_response_code(400);
    exit("Invalid status.");
}

$stmt = $pdo->prepare("
    UPDATE buyer_leads
    SET
        status = ?,
        notes = ?
    WHERE id = ?
");

if ($stmt->execute([$status, $notes, $id])) {
    echo "success";
} else {
    http_response_code(500);
    echo "Failed to update buyer lead.";
}