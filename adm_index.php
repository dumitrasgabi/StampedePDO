<?php
session_start();
require_once 'functions.php';
require_once 'classes/album.php';

if (!is_admin_logged_in()) {
    header("Location: login.php");
    die;
}

?>

<!DOCTYPE html>
<html>
<head>
    <?php include 'the_head.php'; ?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>

<header id="header" class="fixed-top d-flex align-items-center header-transparent">
        <div class="container d-flex justify-content-between align-items-center">
        <div id="logo">
            <a href="adm_index.php"><img src="assets/img/logo.png" alt=""></a>
        </div>
        <nav id="navbar" class="navbar">
            <ul>
            <li><a class="nav-link scrollto active" href="#hero">Acasă</a></li>
            <li><a href="adm_held.php">Albume în așteptare</a></li>
            <li><a href="trendingGet.php">Peretele albumelor în trending</a></li>
            </li>
            <li><a href="logout.php">Logout</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
        </div>
    </header>

    <section id="admin">
        <div class="admin-container" data-aos="zoom-in" data-aos-delay="100">
        <h1> Bine ai revenit, <?php echo isset($_SESSION['ADMIN_SES']['admin_name']) ? htmlspecialchars($_SESSION['ADMIN_SES']['admin_name']) : 'Admin'; ?></h1>
        <h2> Aceasta este o pagină dedicată administratorilor.</h2>
        <canvas id="canvas" width="150" height="150">Ora actuală</canvas>
        <a href="adm_held.php" class="btn-get-started">REVIEW-URI ÎN AȘTEPTARE</a>
        </div>
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
    <script src="assets/js/canvas.js"></script>
</body>

</html>