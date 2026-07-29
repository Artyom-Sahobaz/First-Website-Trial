<?php

session_start();

if (!isset($_SESSION['admin'])) {
    exit(json_encode([
        "success" => false,
        "message" => "Unauthorized"
    ]));
}

require_once("../../includes/config.php");

$id = (int)($_POST['id'] ?? 0);
$status = trim($_POST['status'] ?? '');

$allowed = [
    "New",
    "Contacted",
    "Warm",
    "Offer Sent",
    "Closed",
    "Not Interested"
];

if (!$id || !in_array($status, $allowed, true)) {
    exit(json_encode([
        "success" => false,
        "message" => "Invalid data."
    ]));
}

$stmt = $pdo->prepare("
    UPDATE seller_leads
    SET status=?
    WHERE id=?
");

$stmt->execute([$status, $id]);

echo json_encode([
    "success" => true
]);