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

if ($id <= 0) {
    http_response_code(400);
    exit("Invalid Buyer Lead ID.");
}

$stmt = $pdo->prepare("
    DELETE FROM buyer_leads
    WHERE id = ?
");

if ($stmt->execute([$id])) {

    echo "success";

} else {

    http_response_code(500);
    echo "Unable to delete buyer lead.";

}