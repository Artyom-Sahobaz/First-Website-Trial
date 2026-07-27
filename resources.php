<?php

$pageTitle = "Resources";

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

            <!-- Card 1 -->

            <article class="library-card">

                <div class="library-image">

                    <img src="images/blog1.jpeg" alt="Article">

                    <span class="library-category">Selling</span>

                </div>

                <div class="library-content">

                    <h3>How to Sell Your Mobile Home Fast</h3>

                    <p>Learn the easiest ways to sell your mobile home quickly without unnecessary delays or hidden fees.</p>

                    <a href="article.php" class="library-link">Read More →</a>

                </div>

            </article>

            <!-- Card 2 -->

            <article class="library-card">

                <div class="library-image">

                    <img src="images/blog2.jpeg" alt="Article">

                    <span class="library-category blue">Buying</span>

                </div>

                <div class="library-content">

                    <h3>What to Look for Before Buying</h3>

                    <p>Discover the key things every buyer should inspect before purchasing a manufactured home.</p>

                    <a href="article.php" class="library-link">Read More →</a>

                </div>

            </article>

            <!-- Card 3 -->

            <article class="library-card">

                <div class="library-image">

                    <img src="images/blog3.jpeg" alt="Article">

                    <span class="library-category orange">Tips</span>

                </div>

                <div class="library-content">

                    <h3>Increase Your Home's Value</h3>

                    <p>Simple improvements that can make your mobile home more attractive to buyers.</p>

                    <a href="article.php" class="library-link">Read More →</a>

                </div>

            </article>

            <!-- Card 4 -->

            <article class="library-card">

                <div class="library-image">

                    <img src="images/blog1.jpeg" alt="Article">

                    <span class="library-category">Guides</span>

                </div>

                <div class="library-content">

                    <h3>Understanding the Selling Process</h3>

                    <p>A step-by-step guide to selling your mobile home with confidence.</p>

                    <a href="article.php" class="library-link">Read More →</a>

                </div>

            </article>

        </div>

    </div>

</section>


<?php include 'includes/footer.php'; ?>

