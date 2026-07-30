<?php
session_start();

if (!isset($_SESSION['admin'])) {
    exit("Unauthorized");
}

require_once("../../includes/config.php");

/*=========================================
  Filters
=========================================*/

$search = trim($_GET['search'] ?? '');
$status = trim($_GET['status'] ?? '');

$sql = "
SELECT
    id,
    full_name,
    email,
    phone,
    property_type,
    preferred_location,
    budget,
    status,
    notes,
    created_at
FROM buyer_leads
WHERE 1
";

$params = [];

if ($search !== '') {

    $sql .= "
    AND (
        full_name LIKE ?
        OR email LIKE ?
        OR phone LIKE ?
        OR preferred_location LIKE ?
        OR property_type LIKE ?
        OR budget LIKE ?
    )
    ";

    $keyword = "%{$search}%";

    $params = array_merge($params, [
        $keyword,
        $keyword,
        $keyword,
        $keyword,
        $keyword,
        $keyword
    ]);
}

if ($status !== '') {

    $sql .= " AND status = ? ";

    $params[] = $status;
}

$sql .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*=========================================
  Download CSV
=========================================*/

$filename = "buyer-leads-" . date("Y-m-d-H-i-s") . ".csv";

header("Content-Type: text/csv; charset=UTF-8");
header("Content-Disposition: attachment; filename=\"$filename\"");

$output = fopen("php://output", "w");

/* UTF-8 BOM for Excel */

fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

fputcsv($output, [
    "ID",
    "Full Name",
    "Email",
    "Phone",
    "Property Type",
    "Preferred Location",
    "Budget",
    "Status",
    "Notes",
    "Submitted"
]);

foreach ($rows as $row) {

    fputcsv($output, [
        $row['id'],
        $row['full_name'],
        $row['email'],
        $row['phone'],
        $row['property_type'],
        $row['preferred_location'],
        $row['budget'],
        $row['status'],
        $row['notes'],
        date("Y-m-d H:i:s", strtotime($row['created_at']))
    ]);
}

fclose($output);
exit;