<aside class="sidebar">

    <div class="logo">

        <i class="fa-solid fa-house"></i>

        <div>
            <h2>Cash4MobileHomes</h2>
            <span>Admin Panel</span>
        </div>

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
                   class="<?= basename($_SERVER['PHP_SELF']) == 'seller-leads.php' ? 'active' : ''; ?>">

                    <i class="fa-solid fa-house"></i>

                    <span>Seller Leads</span>

                </a>
            </li>

            <li>
    <a href="buyer-leads.php"
       class="<?= basename($_SERVER['PHP_SELF']) == 'buyer-leads.php' ? 'active' : ''; ?>">

        <i class="fa-solid fa-users"></i>

        <span>Buyer Leads</span>

    </a>
</li>

<li>
    <a href="contact-messages.php"
       class="<?= basename($_SERVER['PHP_SELF']) == 'contact-messages.php' ? 'active' : ''; ?>">

        <i class="fa-solid fa-envelope"></i>

        <span>Contact Messages</span>

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