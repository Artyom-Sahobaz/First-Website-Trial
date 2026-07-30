<?php

require_once("../includes/config.php");

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    echo json_encode([
        "success" => false,
        "message" => "Invalid request."
    ]);

    exit;
}

$full_name = trim($_POST['full_name'] ?? '');
$email     = trim($_POST['email'] ?? '');
$message   = trim($_POST['message'] ?? '');

if ($full_name == "" || $email == "" || $message == "") {

    echo json_encode([
        "success" => false,
        "message" => "Please fill in all fields."
    ]);

    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid email address."
    ]);

    exit;
}

$stmt = $pdo->prepare("
    INSERT INTO contact_messages
    (
        full_name,
        email,
        message
    )
    VALUES
    (
        ?,
        ?,
        ?
    )
");

$stmt->execute([
    $full_name,
    $email,
    $message
]);

echo json_encode([
    "success" => true,
    "message" => "Thank you for contacting us."
]);