<?php

header('Content-Type: application/json');

require 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request.'
    ]);
    exit;
}

$full_name = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$preferred_state = trim($_POST['preferred_state'] ?? '');
$budget = trim($_POST['budget'] ?? '');
$bedrooms = trim($_POST['bedrooms'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($full_name == '' || $email == '' || $phone == '') {
    echo json_encode([
        'success' => false,
        'message' => 'Please fill in all required fields.'
    ]);
    exit;
}

$stmt = $pdo->prepare("
    INSERT INTO buyer_leads
    (
        full_name,
        email,
        phone,
        preferred_location,
        budget,
        property_type,
        message
    )
    VALUES
    (?, ?, ?, ?, ?, ?, ?)
");

$stmt->execute([
    $full_name,
    $email,
    $phone,
    $preferred_state,
    $budget,
    $bedrooms,
    $message
]);

echo json_encode([
    'success' => true
]);