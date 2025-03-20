<?php
session_start();
require_once 'functions.php';

$search_query = isset($_GET['search']) ? $_GET['search'] : '';
$accepted_reviews = get_accepted_reviews($con, $search_query);
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

        .search-form {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .search-input {
            width: 300px;
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-button, .cancel-button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-button {
            background-color: #007bff;
            color: white;
        }

        .cancel-button {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>

<header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <div class="container d-flex justify-content-between align-items-center">
        <div id="logo">
            <a href="index.php"><img src="assets/img/logo.png" alt=""></a>
        </div>
        <nav id="navbar" class="navbar">
            <ul>
                <li class="navbar-item"><a href="index.php">ÎNAPOI ACASĂ</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
    </div>
</header>

<section id="hero">
        <div class="hero-container" data-aos="zoom-in" data-aos-delay="100">
        <h1> Cele mai noi review-uri </h1>
        <h2> Comunitatea noastră a fost ocupată...citește-le review-urile! </h2>
        <a href="#portfolio" class="btn-get-started">Du-te jos</a>
        </div>
</section>



<section id="portfolio">
<section id="search">
    <div class="container">
        <form class="search-form" action="usr_more.php" method="get">
            <input type="text" name="search" placeholder="Caută un album..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" class="search-input">
            <button type="submit" class="search-button">Caută</button>
            <button type="button" class="cancel-button" onclick="cancelSearch()">X</button>
        </form>
    </div>
</section>
    <main id="main">
        <div class="review-container">
            <div class="section-header">
                <br><br>
            </div>
            <div class="container">
                <?php if (count($accepted_reviews) > 0) : ?>
                    <?php foreach ($accepted_reviews as $review) : ?>
                        <div class="review">
                            <div class="review-header">
                                <span> <?php echo htmlspecialchars($review['album_artist']); ?></span> -
                                <span> <?php echo htmlspecialchars($review['album_title']); ?></span> |
                                <span> <?php echo htmlspecialchars($review['album_genre']); ?></span> |
                                <span> <?php echo htmlspecialchars($review['user_name']); ?></span> |
                                <span> <?php echo htmlspecialchars($review['rating']); ?>/5</span>
                            </div>
                            <div class="review-content">
                                <?php echo nl2br(htmlspecialchars($review['content'])); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>Nu s-a putut găsi niciun review. Revin-o mai târziu.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>
</section>

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
<script>
    function cancelSearch() {
        window.location.href = 'usr_more.php';
    }
</script>

</body>
</html>
