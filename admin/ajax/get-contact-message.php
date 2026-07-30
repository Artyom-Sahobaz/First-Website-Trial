<?php

session_start();

if (!isset($_SESSION['admin'])) {

    exit("Unauthorized");

}

require_once("../../includes/config.php");

if (!isset($_GET['id'])) {

    exit("Invalid request.");

}

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("
    SELECT *
    FROM contact_messages
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([$id]);

$message = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$message) {

    exit("<p>Message not found.</p>");

}

/*---------------------------------------
Mark as Read
---------------------------------------*/

if (!$message['is_read']) {

    $pdo->prepare("
        UPDATE contact_messages
        SET is_read = 1
        WHERE id = ?
    ")->execute([$id]);

    $message['is_read'] = 1;

}

?>

<div style="
display:grid;
grid-template-columns:repeat(2,minmax(0,1fr));
gap:24px;
margin-bottom:30px;
">

   <div>

    <label style="
        display:block;
        font-size:13px;
        color:#6b7280;
        margin-bottom:6px;
        font-weight:600;
    ">
        Full Name
    </label>

    <div style="
        font-size:18px;
        font-weight:600;
        color:#1f2937;
    ">
        <?= htmlspecialchars($message['full_name']) ?>
    </div>

</div>

 <div>

    <label style="
        display:block;
        font-size:13px;
        color:#6b7280;
        margin-bottom:6px;
        font-weight:600;
    ">
        Email Address
    </label>

    <div style="
        font-size:18px;
        font-weight:600;
        color:#1f2937;
    ">

        <a
            href="mailto:<?= htmlspecialchars($message['email']) ?>"
            style="
                color:#2563eb;
                text-decoration:none;
            ">

            <?= htmlspecialchars($message['email']) ?>

        </a>

    </div>

</div>

    <div>

    <label style="
        display:block;
        font-size:13px;
        color:#6b7280;
        margin-bottom:6px;
        font-weight:600;
    ">
        Submitted
    </label>

    <div style="
        font-size:18px;
        font-weight:600;
        color:#1f2937;
    ">

        <?= date("F d, Y", strtotime($message['created_at'])) ?>

        <br>

        <span style="
            font-size:14px;
            color:#6b7280;
            font-weight:500;
        ">

            <?= date("h:i A", strtotime($message['created_at'])) ?>

        </span>

    </div>

</div>
    <div>

    <label style="
        display:block;
        font-size:13px;
        color:#6b7280;
        margin-bottom:6px;
        font-weight:600;
    ">
        Status
    </label>

    <?php if($message['is_read']): ?>

        <span class="badge success">Read</span>

    <?php else: ?>

        <span class="badge warning">Unread</span>

    <?php endif; ?>

</div>

</div>

<div class="form-card" style="margin-top:25px;">

    <div class="form-title">
        <h3>Message</h3>
    </div>

    <div style="
        white-space:pre-wrap;
        line-height:1.7;
        padding:18px;
        background:#f8fafc;
        border-radius:10px;
        border:1px solid #e5e7eb;
    ">
        <?= nl2br(htmlspecialchars($message['message'])) ?>
    </div>

</div>

<div style="
    display:flex;
    gap:15px;
    margin-top:25px;
">

    <button
        id="markReadBtn"
        data-id="<?= $message['id'] ?>"
        class="btn success">

        <i class="fa-solid fa-check"></i>

        Mark as Read

    </button>

    <button
        class="btn danger deleteContactBtn"
        data-id="<?= $message['id'] ?>">

        <i class="fa-solid fa-trash"></i>

        Delete Message

    </button>

</div>