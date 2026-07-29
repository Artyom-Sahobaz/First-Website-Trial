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

    $full_name = trim($_POST['full_name']);

    $nameParts = explode(" ", $full_name, 2);

    $first_name = $nameParts[0];
    $last_name  = $nameParts[1] ?? "";

    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    $property_address = trim($_POST['property_address']);
    $city = trim($_POST['city']);
    $state = trim($_POST['state']);
    $zip_code = trim($_POST['zip_code']);

    $home_type = trim($_POST['home_type']);
    $asking_price = !empty($_POST['asking_price']) ? $_POST['asking_price'] : null;
    $message = trim($_POST['message']);

    $stmt = $pdo->prepare("
    INSERT INTO seller_leads
    (
        first_name,
        last_name,
        email,
        phone,
        property_address,
        city,
        state,
        zip_code,
        home_type,
        asking_price,
        message
    )
    VALUES
    (
        ?,?,?,?,?,?,?,?,?,?,?
    )
    ");

    $stmt->execute([
        $first_name,
        $last_name,
        $email,
        $phone,
        $property_address,
        $city,
        $state,
        $zip_code,
        $home_type,
        $asking_price,
        $message
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Lead saved successfully."
    ]);