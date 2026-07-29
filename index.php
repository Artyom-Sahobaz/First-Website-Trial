<?php

require_once 'includes/config.php';

$pageTitle = "Cash4MobileHomes";
$metaDescription = "Sell your mobile home fast with a fair cash offer or browse quality mobile homes for sale nationwide.";

$metaKeywords = "mobile homes, sell mobile home, buy mobile home, cash offer";

$canonicalUrl = "https://cash4mobilehomes.com/";

$metaImage = "https://cash4mobilehomes.com/images/logo.png";

$stmt = $pdo->query("
SELECT *
FROM articles
WHERE status='Published'
ORDER BY created_at DESC
LIMIT 3
");

$latestArticles = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php';

?>

    

<!-- =========================================
     HERO SECTION
========================================= -->

<section class="hero" id="home">

    <div class="hero-background"></div>

    <div class="container">

        <div class="hero-content">

            <div class="hero-badge">
                ✓ Trusted Across the USA
            </div>

            <h1 id="typewriter-container">
                <span class="cursor">|</span>
             </h1>

            <p>
             Get a fair cash offer with zero commissions and close on your schedule.
             Buying and selling mobile homes nationwide has never been easier.
             </p>

            <div class="hero-buttons">

                <a href="#seller-form" class="btn btn-primary">
                    Get My Cash Offer
                </a>

                <a href="#buy" class="btn btn-secondary">
                    I'm Looking to Buy
                </a>

            </div>

            <div class="hero-rating">
                ⭐⭐⭐⭐⭐
                <span>Trusted by Homeowners</span>
            </div>

        </div>

    </div>

    <div class="hero-image"></div>

    <div class="stats-card">

        <div class="stat">
            <h2>10,000+</h2>
            <p>Happy Homeowners</p>
        </div>

        <div class="stat">
            <h2>8,500+</h2>
            <p>Homes Purchased</p>
        </div>

        <div class="stat">
            <h2>72 Hrs</h2>
            <p>Average Closing</p>
        </div>

        <div class="stat">
            <h2>USA</h2>
            <p>Nationwide Service</p>
        </div>

    </div>

</section>

<!-- =========================================
     HOW IT WORKS
========================================= -->

<section class="how-it-works" id="how-it-works">

    <div class="container">

        <div class="section-heading">

            <span class="section-tag">
                HOW IT WORKS
            </span>

            <h2>
                Selling Your Mobile Home
                <br>
                Is Easy
            </h2>

            <p>
                From your first message to getting paid, we keep
                the process simple, transparent, and stress-free.
            </p>

        </div>

        <div class="steps">

            <div class="step-card">

                <div class="step-number">
                    01
                </div>

                <h3>Tell Us About Your Home</h3>

                <p>
                    Fill out our short form with a few details
                    about your mobile home.
                </p>

            </div>

            <div class="step-card">

                <div class="step-number">
                    02
                </div>

                <h3>Receive Your Cash Offer</h3>

                <p>
                    We'll review your information and send you
                    a fair, no-obligation cash offer.
                </p>

            </div>

            <div class="step-card">

                <div class="step-number">
                    03
                </div>

                <h3>Close & Get Paid</h3>

                <p>
                    Choose a closing date that works for you
                    and receive your payment.
                </p>

            </div>

        </div>

    </div>

</section>
<!-- =========================================
     WHY SELL TO CASH4MOBILEHOMES
========================================= -->

<section class="why-us">

    <div class="container">

        <div class="section-heading">

            <span class="section-tag">
                WHY SELL TO CASH4MOBILEHOMES
            </span>

            <h2>
                The Smarter Way to Sell
                <br>
                Your Mobile Home
            </h2>

            <p>
                We simplify every step so you can sell faster,
                avoid unnecessary fees, and move forward with confidence.
            </p>

        </div>

        <div class="why-grid">

            <div class="why-image">

                <img src="images/interior.jpeg" alt="Mobile Home">

            </div>

            <div class="why-features">

                <div class="feature-card">
                    <div class="feature-icon">✓</div>
                    <div>
                        <h3>Sell As-Is</h3>
                        <p>No repairs or renovations required.</p>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">✓</div>
                    <div>
                        <h3>No Realtor Commissions</h3>
                        <p>Keep more of your money.</p>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">✓</div>
                    <div>
                        <h3>Fair Cash Offers</h3>
                        <p>Transparent pricing with no pressure.</p>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">✓</div>
                    <div>
                        <h3>Close On Your Schedule</h3>
                        <p>Choose a timeline that works for you.</p>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">✓</div>
                    <div>
                        <h3>Nationwide Service</h3>
                        <p>Helping homeowners across the USA.</p>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">✓</div>
                    <div>
                        <h3>Friendly Support</h3>
                        <p>Real people ready to answer your questions.</p>
                    </div>
                </div>

            </div>

        </div>

    </div>

</section>
<!-- =========================================
     SELLER FORM
========================================= -->

<section class="seller-section" id="seller-form">

    <div class="container">

        <div class="section-heading">

            <span class="section-tag">
                GET MY CASH OFFER
            </span>

            <h2>
                Ready to Sell Your
                <br>
                <span class="green-text">Mobile Home?</span>
            </h2>

            <p>
                Get a fair cash offer with zero commissions,
                no hidden fees, and absolutely no obligation.
            </p>

        </div>

        <div class="seller-grid">

            <div class="seller-info">

                <h3>Why Homeowners <br>Choose Us?</h3>

                <div class="benefit">
                    ✓ Sell Your Home As-Is
                </div>

                <div class="benefit">
                    ✓ No Realtor Commissions
                </div>

                <div class="benefit">
                    ✓ Close On Your Timeline
                </div>

                <div class="benefit">
                    ✓ Nationwide Buyers
                </div>

                <div class="benefit">
                    ✓ Fast & Secure Process
                </div>
                <div class="seller-logo">
                  <img src="images/logo.png" alt="Cash4MobileHomes Logo">
                </div>

            </div>

            <form class="seller-form">

                <input type="text" placeholder="Full Name" required>

                <input type="email" placeholder="Email Address" required>

                <input type="tel" placeholder="Phone Number" required>

                <input type="text" placeholder="City">

                <input type="text" placeholder="State">

                <input type="text" placeholder="Mobile Home Make">

                <input type="text" placeholder="Asking Price">

                <textarea placeholder="Tell us about your mobile home..." rows="5"></textarea>

                <button class="submit-btn">
                    Get My Cash Offer
                </button>

            </form>

        </div>

    </div>

</section>
<!-- =========================================
     BUYER SECTION
========================================= -->

<section class="buyer-section" id="buy">

    <div class="container">

        <div class="section-heading">

          <span class="section-tag blue-tag">
           FIND YOUR NEXT HOME
           </span>

           <h2>
           Looking to Buy Your
            <br>
             Dream <span class="blue-text">Mobile Home?</span>
            </h2>
 
           <p>
                Complete the form below and tell us exactly what you're looking for.
               Our team will help you find the right mobile home that fits your
                  needs and budget.
             </p>

        </div>       

        <div class="buyer-grid">

            <!-- LEFT -->
            <div class="buyer-form">

                <h3>Tell Us What You're Looking For</h3>

                <input type="text" placeholder="Full Name" required>

                <input type="email" placeholder="Email Address" required>

                <input type="tel" placeholder="Phone Number" required>

                <input type="text" placeholder="Preferred State">

                <input type="text" placeholder="Budget">

                <input type="text" placeholder="Bedrooms">

                <textarea rows="5"
                    placeholder="Tell us what kind of mobile home you're looking for..."></textarea>

                <button class="buyer-submit">
                    Send My Request
                </button>

            </div>

            <!-- RIGHT -->
            <div class="buyer-image">

                <div class="buyer-badge">
                    ✓ Nationwide Listings
                </div>

                <img src="images/buy-mobil-home.jpeg"
                    alt="Mobile Home">

                <p class="buyer-caption">
                    Helping families find quality mobile homes
                    across the USA.
                </p>

            </div>

        </div>

    </div>

</section>
<!-- =========================================
     WHY CHOOSE US
========================================= -->

<section class="trust-section" id="why-us">

    <div class="container">

        <div class="section-heading">

            <span class="section-tag">
                WHY CHOOSE CASH4MOBILEHOMES
            </span>

            <h2>
                A Simpler Way to Buy & Sell
                <br>
                <span class="green-text">Mobile</span><span class="blue-text">Homes</span>
            </h2>

            <p>
                Whether you're buying or selling, we're committed to making the
                process simple, transparent, and stress-free from start to finish.
            </p>

        </div>

        <div class="trust-grid">

            <div class="trust-card">

                <div class="trust-icon">🏡</div>

                <h3>Fair Offers</h3>

                <p>
                    We believe in straightforward pricing and fair opportunities
                    for every homeowner.
                </p>

            </div>

            <div class="trust-card">

                <div class="trust-icon">💵</div>

                <h3>No Hidden Fees</h3>

                <p>
                    No surprise charges or unnecessary costs throughout the
                    buying or selling process.
                </p>

            </div>

            <div class="trust-card">

                <div class="trust-icon">🤝</div>

                <h3>Friendly Support</h3>

                <p>
                    Our team is here to answer your questions and guide you every
                    step of the way.
                </p>

            </div>

            <div class="trust-card">

                <div class="trust-icon">🇺🇸</div>

                <h3>Nationwide Service</h3>

                <p>
                    We help buyers and sellers connect across the United States.
                </p>

            </div>

        </div>

    </div>

</section>
<!-- =========================================
     RESOURCES
========================================= -->

<section class="resources-section" id="resources">

    <div class="container">

        <div class="section-heading">

            <span class="section-tag">
                RESOURCES
            </span>

            <h2>
                Learn More About
                <br>
                <span class="green-text">Mobile Homes</span>
            </h2>

            <p>
                Explore helpful guides, buying tips, selling advice,
                and expert insights to help you make informed decisions.
            </p>

        </div>

        <div class="resources-grid">

<?php foreach($latestArticles as $article): ?>

<?php

$badge = "category-other";

switch($article['category']){

    case "Selling Tips":
        $badge = "category-selling";
        break;

    case "Buying":
        $badge = "category-buying";
        break;

    case "Guides":
        $badge = "category-guides";
        break;

    case "Financing":
        $badge = "category-financing";
        break;

    case "Maintenance":
        $badge = "category-maintenance";
        break;
}

?>

<article class="resource-card">

    <div class="resource-image">

        <img
            src="<?= htmlspecialchars($article['featured_image']); ?>"
            alt="<?= htmlspecialchars($article['title']); ?>">

        <span class="resource-category <?= $badge; ?>">
            <?= htmlspecialchars($article['category']); ?>
        </span>

    </div>

    <div class="resource-content">

        <h3>
            <?= htmlspecialchars($article['title']); ?>
        </h3>

        <p>
            <?= htmlspecialchars($article['excerpt']); ?>
        </p>

        <a
            href="article.php?slug=<?= urlencode($article['slug']); ?>"
            class="resource-link">

            Read Article →

        </a>

    </div>

</article>

<?php endforeach; ?>

</div>

        <div class="resources-button">

              <a href="resources.php" class="btn outline-btn">

             Explore All Articles

             </a>

</div>

    </div>

</section>

<!-- =========================================
     CONTACT US
========================================= -->

<section class="contact-section" id="contact">

    <div class="container">

        <div class="section-heading">

            <span class="section-tag">

                CONTACT US

            </span>

            <h2>

                We'd Love To
                <span class="green-text">Hear From You</span>

            </h2>

            <p>

                Whether you're buying or selling a mobile home,
                our team is here to answer your questions.

            </p>

        </div>

        <div class="contact-grid">

            <!-- Left -->

            <div class="contact-info">

                <div class="contact-card">

                    <h3>Contact Information</h3>
                      <div class="contact-logo">

                        <img src="images/logo.png"
                             alt="Cash4MobileHomes Logo">
                       </div>      

                    <p>📞 (123) 456-7890</p>

                    <p>✉ hello@cash4mobilehomes.com</p>

                    <p>📍 Based in Alabama</p>

                    <p>🕒 24/7 Support</p>

                </div>
                

            </div>

            <!-- Right -->

            <div class="contact-form">

                <form>

                    <input
                        type="text"
                        placeholder="Your Name">

                    <input
                        type="email"
                        placeholder="Email Address">

                    <input
                        type="text"
                        placeholder="Subject">

                    <textarea
                        placeholder="Your Message"></textarea>

                    <button>

                        Send Message

                    </button>

                </form>

            </div>

        </div>

    </div>

</section>

<?php include 'includes/footer.php'; ?>