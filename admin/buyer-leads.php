<?php
session_start();

require '../includes/config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->query("
    SELECT *
    FROM buyer_leads
    ORDER BY created_at DESC
");

$leads = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Buyer Leads</title>

    <link rel="stylesheet" href="css/admin.css">

</head>

<body>

<h1>Buyer Leads</h1>

<table border="1" cellpadding="10" cellspacing="0" width="100%">

    <tr>
        <th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Preferred State</th>
<th>Budget</th>
<th>Bedrooms</th>
<th>Date</th>
    </tr>

    <?php foreach ($leads as $lead): ?>

    <tr>

        <td><?= $lead['id']; ?></td>

<td><?= htmlspecialchars($lead['full_name']); ?></td>

<td><?= htmlspecialchars($lead['email']); ?></td>

<td><?= htmlspecialchars($lead['phone']); ?></td>

<td><?= htmlspecialchars($lead['preferred_location']); ?></td>

<td><?= htmlspecialchars($lead['budget']); ?></td>

<td><?= htmlspecialchars($lead['property_type']); ?></td>

<td><?= date('M d, Y', strtotime($lead['created_at'])); ?></td>

    </tr>

    <?php endforeach; ?>

</table>

</body>

</html>