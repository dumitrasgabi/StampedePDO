<?php
session_start();
require_once 'functions.php';
require_once 'util_pentru_poo.php';

if (!is_admin_logged_in()) {
    header("Location: login.php");
    die;
}

$album = new Album($con, "Title", "Artist", "Genre");
$albumsForReview = Album::getAlbumsForReview($con);
$pending_reviews = get_pending_reviews();

?>

<!DOCTYPE html>
<html>
<head>
    <?php include 'the_head.php'; ?>
    <style>

        .review {
            border: 5px solid #ccc;
            padding: 5px;
            margin: 10px 0;
        }

        .review-header {
            font-weight: bold;
        }

        .review-content {
            margin-top: 10px;
        }

        .review-container {
            min-height: 100px;
        }

    </style>
</head>

<body>

<header id="header" class="fixed-top d-flex align-items-center header-transparent">
        <div class="container d-flex justify-content-between align-items-center">
        <div id="logo">
            <a href="adm_index.php"><img src="assets/img/logo.png" alt=""></a>
        </div>
        <nav id="navbar" class="navbar">
            <ul><li><a href="adm_index.php">Acasă</a></li></ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
        </div>
</header>

<section id="admin">
        <div class="admin-container" data-aos="zoom-in" data-aos-delay="100">
        <h1> ALBUME ÎN AȘTEPTARE</h1>
        <h2> Să vedem ce recenzii așteaptă să primească ... recenzii </h2>
        </div>
</section>
    
<main id="main">
<section id="portfolio" class="portfolio">
    <div class="review-container">
        <div class="container">
            <?php if (count($pending_reviews) > 0) : ?>
            <?php foreach ($pending_reviews as $review) : ?>
                <div class="review">
                    <div class="review-header">
                        <span>Album: <?php echo htmlspecialchars($review['album_title']); ?></span> |
                        <span>Scris de: <?php echo htmlspecialchars($review['user_name']); ?></span> |
                        <span>Notă: <?php echo htmlspecialchars($review['rating']); ?>/5</span>
                    </div>
                    <div class="review-content">
                        <?php echo nl2br(htmlspecialchars($review['content'])); ?>
                    </div>
                    <!-- Aprobă Button -->
                    <form action="adm_approve.php" method="post" style="display: inline;">
                        <input type="hidden" name="review_id" value="<?php echo htmlspecialchars($review['id']); ?>">
                        <button type="submit">Aprobă</button>
                    </form>
                    <!-- Respinge Button -->
                    <form action="adm_reject.php" method="post" style="display: inline;">
                        <input type="hidden" name="review_id" value="<?php echo htmlspecialchars($review['id']); ?>">
                        <button type="submit">Respinge</button>
                    </form>
                </div>
            <?php endforeach; ?>
            <?php else : ?>
            <p>Nu ai albume în așteptare.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
</main>

    <?php include 'the_footer.php'; ?>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/js/main.js"></script>

</body>

</html>