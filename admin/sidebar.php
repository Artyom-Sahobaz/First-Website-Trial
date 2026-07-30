<?php

$currentPage = basename($_SERVER['PHP_SELF']);

$sellerUnread = $pdo->query("
    SELECT COUNT(*)
    FROM seller_leads
    WHERE is_read = 0
")->fetchColumn();

$buyerUnread = $pdo->query("
    SELECT COUNT(*)
    FROM buyer_leads
    WHERE is_read = 0
")->fetchColumn();

$contactUnread = $pdo->query("
    SELECT COUNT(*)
    FROM contact_messages
    WHERE is_read = 0
")->fetchColumn();

?>
<aside class="sidebar">
    

   <div class="logo">

    <a href="dashboard.php" class="brand">

        <i class="fa-solid fa-house"></i>

        <div class="brand-text">

            <h2>Cash4MobileHomes</h2>

            <span>ADMIN PANEL</span>

        </div>

    </a>

</div>

    <nav>

        <ul>

            <li>
                <a href="dashboard.php"
                   class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">

                    <i class="fa-solid fa-gauge-high"></i>

                    <span>Dashboard</span>

                </a>
            </li>

            <li>

    <a href="seller-leads.php"
       class="<?= $currentPage == 'seller-leads.php' ? 'active' : ''; ?>">

        <i class="fa-solid fa-house"></i>

        <span>Seller Leads</span>

        <?php if($sellerUnread > 0): ?>

    <span
        id="sellerLeadBadge"
        class="menu-badge">

        <?= $sellerUnread ?>

    </span>

<?php endif; ?>

    </a>

</li>

            <li>

    <a href="buyer-leads.php"
       class="<?= $currentPage == 'buyer-leads.php' ? 'active' : ''; ?>">

        <i class="fa-solid fa-users"></i>

        <span>Buyer Leads</span>

        <?php if($buyerUnread > 0): ?>

            <span
    id="buyerLeadBadge"
    class="menu-badge">

    <?= $buyerUnread ?>

</span>

        <?php endif; ?>

    </a>

</li>

<li>

    <a href="contact-messages.php"
       class="<?= $currentPage == 'contact-messages.php' ? 'active' : ''; ?>">

        <i class="fa-solid fa-envelope"></i>

        <span>Contact Messages</span>

        <?php if($contactUnread > 0): ?>

            <span
    id="contactBadge"
    class="menu-badge">

    <?= $contactUnread ?>

</span>

        <?php endif; ?>

    </a>

</li>

<li>
    <a href="articles.php"
       class="<?= basename($_SERVER['PHP_SELF']) == 'articles.php' ? 'active' : ''; ?>">

                    <i class="fa-solid fa-newspaper"></i>

                    <span>Articles</span>

                </a>
            </li>

            <li>
                <a href="add-article.php"
                   class="<?= basename($_SERVER['PHP_SELF']) == 'add-article.php' ? 'active' : ''; ?>">

                    <i class="fa-solid fa-plus"></i>

                    <span>Add Article</span>

                </a>
            </li>

            <li>
                <a href="../index.php" target="_blank">

                    <i class="fa-solid fa-globe"></i>

                    <span>View Website</span>

                </a>
            </li>

        </ul>

    </nav>

    <div style="margin-top:auto;padding-top:30px;">

        <a href="logout.php"
           class="btn danger w-100">

            <i class="fa-solid fa-right-from-bracket"></i>

            Logout

        </a>

    </div>

</aside>