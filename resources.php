<?php

$pageTitle = "Resources";
$metaDescription = "Browse expert guides, buying tips, selling advice, financing information, and maintenance resources for mobile homes.";

$metaKeywords = "mobile home guides, buying, selling, financing";

$canonicalUrl = "https://cash4mobilehomes.com/resources.php";

$metaImage = "https://cash4mobilehomes.com/images/logo.png";

require_once 'includes/config.php';

// Fetch all published articles
// Pagination
$articlesPerPage = 9;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

// Count total published articles
$totalStmt = $pdo->query("
    SELECT COUNT(*)
    FROM articles
    WHERE status='Published'
");

$totalArticles = $totalStmt->fetchColumn();

$totalPages = ceil($totalArticles / $articlesPerPage);

if ($page > $totalPages && $totalPages > 0) {
    $page = $totalPages;
}

$offset = ($page - 1) * $articlesPerPage;

// Load only the current page
$stmt = $pdo->prepare("
    SELECT *
    FROM articles
    WHERE status='Published'
    ORDER BY created_at DESC
    LIMIT :limit OFFSET :offset
");

$stmt->bindValue(':limit', $articlesPerPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

$stmt->execute();

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
<?php if($totalPages > 1): ?>

<section class="pagination-section">

    <div class="container">

        <div class="pagination">

            <?php if($page > 1): ?>

                <a href="?page=<?= $page-1; ?>">&laquo;</a>

            <?php endif; ?>

            <?php

            $start = max(1, $page - 2);
            $end   = min($totalPages, $page + 2);

            if($start > 1){
                echo '<a href="?page=1">1</a>';

                if($start > 2){
                    echo '<span>...</span>';
                }
            }

            for($i = $start; $i <= $end; $i++): ?>

                <a
                    href="?page=<?= $i; ?>"
                    class="<?= $i == $page ? 'active' : ''; ?>">

                    <?= $i; ?>

                </a>

            <?php endfor;

            if($end < $totalPages){

                if($end < $totalPages-1){
                    echo '<span>...</span>';
                }

                echo '<a href="?page='.$totalPages.'">'.$totalPages.'</a>';

            }

            ?>

            <?php if($page < $totalPages): ?>

                <a href="?page=<?= $page+1; ?>">&raquo;</a>

            <?php endif; ?>

        </div>

    </div>

</section>

<?php endif; ?>

<?php include 'includes/footer.php'; ?>