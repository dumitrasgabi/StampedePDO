<?php
session_start();
require 'functions.php';

if (!is_logged_in() && !is_admin_logged_in()) {
    header("Location: login.php");
    die;
}
else{
    if (is_admin_logged_in()) {
        header("Location: adm_index.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <?php include 'the_head.php'; ?>
    <title>Write a Review</title>
    <style>
        .message {
            display: none;
            text-align: left;
            padding: 15px;
            font-weight: 600;
            margin: 20px 0;
        }
    </style>
</head>

<body>
<header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <div class="container d-flex justify-content-between align-items-center">
        <div id="logo">
            <a href="index.php"><img src="assets/img/blue-logo.png" alt=""></a>
        </div>
        <nav id="navbar" class="navbar">
            <ul><li><a href="index.php">ÎNAPOI ACASĂ</a></li></ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
    </div>
</header>

<section id="contact">
    <div class="login-container">
        <div class="container">
            <div class="section-header">
                <h3 class="section-title">CREEAZĂ UN TABEL ÎN MYSQL</h3>
                <p class="section-description">Te rog să introduci numele tabelului, dar și cod mysql în a doua rubrică:</p>
            </div>
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger">
                    <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                </div>
            <?php endif; ?>
            <form action="util_creare_tabel.php" method="post" enctype="multipart/form-data">
                <label for="db_name">Nume Tabelă:</label><br>
                <input type="text" name="db_name" required><br>
                <label for="columns">Cod Mysql Pentru Coloane:</label><br>
                <input type="text" name="columns" required><br><br><br>
                <button type="submit" class="btn-get-started">Creează</button><br><br>
            </form>
        </div>
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

</body>
</html>