<?php

$pageTitle = "Resources";

require_once 'includes/config.php';

// Fetch all published articles
$stmt = $pdo->query("SELECT * FROM articles WHERE status='Published' ORDER BY created_at DESC");
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php';

?>

<section class="resources-hero">

    <div class="container">

        <div class="breadcrumb">
            <a href="index.php">Home</a>
            <span>/</span>
            <span>Resources</span>
        </div>

        <h1>Mobile Home Resources</h1>

        <p>
            Expert guides for buying and selling mobile homes.
        </p>

    </div>

</section>

<section class="resources-filter">

    <div class="container">

        <div class="search-box">
            <input
                type="text"
                placeholder="Search articles..."
            >
        </div>

    </div>

    <div class="category-filter">

        <button class="category-btn active">All</button>
        <button class="category-btn">Selling</button>
        <button class="category-btn">Buying</button>
        <button class="category-btn">Financing</button>
        <button class="category-btn">Mobile Home Tips</button>

    </div>

</section>

<section class="resource-library">

    <div class="container">

        <div class="library-grid">

            <?php if (!empty($articles)): ?>

                <?php foreach ($articles as $article): ?>

                    <article class="library-card">

                        <div class="library-image">

                            <img
                                src="<?= htmlspecialchars($article['featured_image']); ?>"
                                alt="<?= htmlspecialchars($article['title']); ?>">

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

<span class="library-category <?= $categoryClass; ?>">
    <?= htmlspecialchars($article['category']); ?>
</span>
                            

                        </div>

                        <div class="library-content">

                            <h3><?= htmlspecialchars($article['title']); ?></h3>

                            <p><?= htmlspecialchars($article['excerpt']); ?></p>

                            <a href="article.php?slug=<?= urlencode($article['slug']); ?>" class="library-link">
                                Read More →
                            </a>

                        </div>

                    </article>

                <?php endforeach; ?>

            <?php else: ?>

                <p>No articles found.</p>

            <?php endif; ?>

        </div>

    </div>

</section>

<section class="pagination-section">

    <div class="container">

        <div class="pagination">

            <a href="#" class="active">1</a>

        </div>

    </div>

</section>

<?php include 'includes/footer.php'; ?>