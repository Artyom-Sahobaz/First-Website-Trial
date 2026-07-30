<?php
require_once("../includes/auth.php");
require_once("../includes/config.php");

$totalMessages = $pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();

$unreadMessages = $pdo->query("
    SELECT COUNT(*)
    FROM contact_messages
    WHERE is_read = 0
")->fetchColumn();

$readMessages = $pdo->query("
    SELECT COUNT(*)
    FROM contact_messages
    WHERE is_read = 1
")->fetchColumn();

$todayMessages = $pdo->query("
    SELECT COUNT(*)
    FROM contact_messages
    WHERE DATE(created_at)=CURDATE()
")->fetchColumn();

$search = trim($_GET['search'] ?? '');

$page = max(1, (int)($_GET['page'] ?? 1));

$limit = 15;

$offset = ($page-1) * $limit;

$where = "";

$params = [];

if($search != ""){

    $where = "
        WHERE
        full_name LIKE ?
        OR email LIKE ?
        OR message LIKE ?
    ";

    $like = "%{$search}%";

    $params = [$like,$like,$like];
}

$countSql = "
SELECT COUNT(*)
FROM contact_messages
$where
";

$stmt = $pdo->prepare($countSql);
$stmt->execute($params);

$totalRows = $stmt->fetchColumn();

$totalPages = ceil($totalRows/$limit);

$sql = "
SELECT *
FROM contact_messages
$where
ORDER BY created_at DESC
LIMIT $limit OFFSET $offset
";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("includes/header.php"); ?>

<div class="content">

<div class="page-header">

<h1>Contact Messages</h1>

</div>

<div class="stats-grid">

<div class="stat-card">
<h3><?= $totalMessages ?></h3>
<p>Total Messages</p>
</div>

<div class="stat-card">
<h3><?= $unreadMessages ?></h3>
<p>Unread</p>
</div>

<div class="stat-card">
<h3><?= $readMessages ?></h3>
<p>Read</p>
</div>

<div class="stat-card">
<h3><?= $todayMessages ?></h3>
<p>Today</p>
</div>

</div>

<div class="table-toolbar">

<input
type="text"
id="searchInput"
placeholder="Search messages..."
value="<?= htmlspecialchars($search) ?>">

</div>

<table class="data-table">

<thead>

<tr>

<th>Name</th>
<th>Email</th>
<th>Status</th>
<th>Date</th>
<th>Actions</th>

</tr>

</thead>

<tbody>

<?php foreach($messages as $row): ?>

<tr>

<td><?= htmlspecialchars($row['full_name']) ?></td>

<td><?= htmlspecialchars($row['email']) ?></td>

<td>

<span class="status-badge <?= $row['is_read'] ? 'completed' : 'pending' ?>">

<?= $row['is_read'] ? 'Read' : 'Unread' ?>

</span>

</td>

<td><?= date("M d, Y",strtotime($row['created_at'])) ?></td>

<td>

<button
class="view-btn"
data-id="<?= $row['id'] ?>">

View

</button>

<button
class="delete-btn"
data-id="<?= $row['id'] ?>">

Delete

</button>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

<div id="pagination"></div>

</div>

<?php include("includes/footer.php"); ?>