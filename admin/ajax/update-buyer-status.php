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

$allowed = [
    "New",
    "Contacted",
    "Offer Sent",
    "Closed",
    "Not Interested"
];

if ($id <= 0) {
    http_response_code(400);
    exit("Invalid Buyer Lead ID.");
}

if (!in_array($status, $allowed, true)) {
    http_response_code(400);
    exit("Invalid status.");
}

$stmt = $pdo->prepare("
    UPDATE buyer_leads
    SET status = ?
    WHERE id = ?
");

if ($stmt->execute([$status, $id])) {

    echo "success";

} else {

    http_response_code(500);
    echo "Unable to update buyer status.";

}