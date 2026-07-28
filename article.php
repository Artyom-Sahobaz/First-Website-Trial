<?php

require_once 'includes/config.php';

if (!isset($_GET['slug'])) {
    die("Article not found.");
}

$slug = $_GET['slug'];

$stmt = $pdo->prepare("SELECT * FROM articles WHERE slug = ? AND status = 'Published'");
$stmt->execute([$slug]);

$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    die("Article not found.");
}

$pageTitle = $article['meta_title'];

include 'includes/header.php';

?>

<!-- =========================================
     ARTICLE HERO
========================================= -->

<section class="article-hero">

    <div class="container article-hero-content">

        <div class="breadcrumb">

            <a href="index.php">Home</a>

            <span>/</span>

            <a href="resources.php">Resources</a>

            <span>/</span>

            <span>Article</span>

        </div>

        <?php

$categoryClass = "category-other";

switch($article['category']){

    case "Selling Tips":
        $categoryClass = "category-selling";
        break;

    case "Buying":
        $categoryClass = "category-buying";
        break;

    case "Guides":
        $categoryClass = "category-guides";
        break;

    case "Financing":
        $categoryClass = "category-financing";
        break;

    case "Maintenance":
        $categoryClass = "category-maintenance";
        break;
}

?>

<span class="article-category category-badge <?= $categoryClass; ?>">
    <?= htmlspecialchars($article['category']); ?>
</span>

        <h1>
           <?= htmlspecialchars($article['title']); ?>
        </h1>

        <p class="article-description">
              <?= htmlspecialchars($article['excerpt']); ?>
             </p>

        <div class="article-meta">

    <span>📅 <?= date('F j, Y', strtotime($article['created_at'])); ?></span>

</div>

    </div>

</section>

<!-- =========================================
     FEATURED IMAGE
========================================= -->

<section class="article-featured">

    <div class="container">

        <img
            src="<?= htmlspecialchars($article['featured_image']); ?>"
            alt="<?= htmlspecialchars($article['title']); ?>">

    </div>

</section>

<!-- =========================================
     ARTICLE CONTENT
========================================= -->
<section class="article-content">

    <div class="container article-container">

        <?= $article['content']; ?>

    </div>

</section>
<section class="article-faq">

    <div class="container">

        <div class="section-heading">

            <span>FAQs</span>

            <h2>Frequently Asked Questions</h2>

            <p>Answers to common questions about selling your mobile home.</p>

        </div>

        <div class="faq-container">

            <div class="faq-item active">

                <button class="faq-question">
                    How quickly can I sell my mobile home?
                    <span>+</span>
                </button>

                <div class="faq-answer">
                    <p>Most sellers receive a cash offer quickly, and many sales can close within a few days depending on the title and property details.</p>
                </div>

            </div>

            <div class="faq-item">

                <button class="faq-question">
                    Do you buy mobile homes in any condition?
                    <span>+</span>
                </button>

                <div class="faq-answer">
                    <p>Yes. We purchase mobile homes in good, fair, or poor condition, so you don't need to make repairs before selling.</p>
                </div>

            </div>

            <div class="faq-item">

                <button class="faq-question">
                    Are there any fees or commissions?
                    <span>+</span>
                </button>

                <div class="faq-answer">
                    <p>No. There are no agent commissions, hidden fees, or closing costs when you sell directly to us.</p>
                </div>

            </div>

            <div class="faq-item">

                <button class="faq-question">
                    What paperwork do I need?
                    <span>+</span>
                </button>

                <div class="faq-answer">
                    <p>Typically you'll need the title and a valid ID. If you're missing paperwork, contact us and we'll explain your options.</p>
                </div>

            </div>

        </div>

    </div>

</section>
<section class="related-articles">

    <div class="container">

        <div class="section-heading">

            <span>Keep Reading</span>

            <h2>Related Articles</h2>

            <p>Explore more helpful resources for mobile homeowners.</p>

        </div>

        <div class="related-grid">

            <a href="article.php" class="related-card">

                <img src="images/blog1.jpeg" alt="">

                <div class="related-content">

                    <span>Selling Tips</span>

                    <h3>How to Sell a Mobile Home Fast</h3>

                </div>

            </a>

            <a href="article.php" class="related-card">

                <img src="images/blog3.jpeg" alt="">

                <div class="related-content">

                    <span>Guides</span>

                    <h3>What Paperwork Do You Need?</h3>

                </div>

            </a>

            <a href="article.php" class="related-card">

                <img src="images/blog2.jpeg" alt="">

                <div class="related-content">

                    <span>Buying</span>

                    <h3>Can You Sell Without a Title?</h3>

                </div>

            </a>

        </div>

    </div>

</section>

<?php include 'includes/footer.php'; ?>