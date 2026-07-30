<?php

session_start();

if (!isset($_SESSION['admin'])) {

    exit("Unauthorized");

}

require_once("../../includes/config.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    exit("Invalid request");

}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {

    exit("Invalid ID");

}

$stmt = $pdo->prepare("
    UPDATE contact_messages
    SET is_read = 1
    WHERE id = ?
");

$stmt->execute([$id]);

echo "success";