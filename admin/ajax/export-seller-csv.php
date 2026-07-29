<?php

session_start();

if (!isset($_SESSION['admin'])) {
    exit;
}

require_once("../../includes/config.php");

$search = trim($_GET['search'] ?? '');
$status = trim($_GET['status'] ?? '');

$sql = "SELECT *
        FROM seller_leads
        WHERE 1";

$params = [];

if ($search !== '') {

    $sql .= " AND (
        first_name LIKE ?
        OR last_name LIKE ?
        OR email LIKE ?
        OR phone LIKE ?
        OR city LIKE ?
        OR state LIKE ?
        OR property_address LIKE ?
    )";

    $term = "%{$search}%";

    for ($i = 0; $i < 7; $i++) {
        $params[] = $term;
    }
}

if ($status !== '') {

    $sql .= " AND status = ?";

    $params[] = $status;
}

$sql .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);

$stmt->execute($params);

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=seller-leads.csv");

$output = fopen("php://output", "w");

fputcsv($output, [

    "ID",
    "First Name",
    "Last Name",
    "Email",
    "Phone",
    "Property Address",
    "City",
    "State",
    "ZIP",
    "Status",
    "Notes",
    "Created"

]);

while ($lead = $stmt->fetch(PDO::FETCH_ASSOC)) {

    fputcsv($output, [

        $lead['id'],
        $lead['first_name'],
        $lead['last_name'],
        $lead['email'],
        $lead['phone'],
        $lead['property_address'],
        $lead['city'],
        $lead['state'],
        $lead['zip'],
        $lead['status'],
        $lead['notes'],
        $lead['created_at']

    ]);

}

fclose($output);

exit;