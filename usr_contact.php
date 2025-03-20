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
</head>

<body>

<header id="header" class="fixed-top d-flex align-items-center header-transparent">
        <div class="container d-flex justify-content-between align-items-center">
        <div id="logo">
            <a href="index.php"><img src="assets/img/logo.png" alt=""></a>
        </div>
        <nav id="navbar" class="navbar">
            <li><a href="index.php">Înapoi acasă</a></li>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
        </div>
    </header>

    <section id="hero">
        <div class="hero-container" data-aos="zoom-in" data-aos-delay="100">
        <h1> Contactează-ne </h1>
        <h2> Raportează un bug, un cont, sau scrie-ne orice: </h2>
        <a href="#contact" class="btn-get-started">Du-te jos</a>
        </div>
    </section>

    <section id="contact">
        <div class="container">
            <div class="section-header">
            <h3 class="section-title">Ne poți găsi aici</h3>
            <p class="section-description">Sau ne poți scrie:</p>
            </div>
        </div>

        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2585.0192604266012!2d27.572141957985046!3d47.174473115846766!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40cafb61af5ef507%3A0x95f1e37c73c23e74!2sUniversitatea%20%E2%80%9EAlexandru%20Ioan%20Cuza%E2%80%9D!5e1!3m2!1sro!2sro!4v1716292829942!5m2!1sro!2sro" width="100%" height="380" frameborder="0" style="border:0" allowfullscreen></iframe>
            
        <div class="container mt-5">
            <div class="row justify-content-center">

            <div class="col-lg-3 col-md-4">

                <div class="info">
                <div>
                    <i class="bi bi-geo-alt"></i>
                    <p>Bulevardul Carol I 11<br>Iași, 700506</p>
                </div>

                <div>
                    <i class="bi bi-envelope"></i>
                    <p>gabidumitras04@gmail.com</p>
                </div>

                <div>
                    <i class="bi bi-phone"></i>
                    <p>+40 767 760 435</p>
                </div>
                </div>

                <div class="social-links">
                <a href="https://x.com/doom_n_thrash" target="_blank" class="twitter-x"><i class="bi bi-twitter-x"></i></a>
                <a href="https://www.facebook.com/doom.n.thrash" target="_blank" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="https://www.instagram.com/top_10_despre_dracu" target="_blank" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="https://www.youtube.com/@StampedeDesign" target="_blank" class="youtube"><i class="bi bi-youtube"></i></a>
                <a href="https://ro.pinterest.com/stampede_axxa/" target="_blank" class="pinterest"><i class="bi bi-pinterest"></i></a>
                </div>
            </div>
            </div>
        </div>
    
    <svg width="300" height="200">
        <polygon points="100,10 40,198 190,78 10,78 160,198"
        style="fill:crimson;stroke:black;stroke-width:5;fill-rule:evenodd;" />
    </svg>
    <svg width="300" height="200">
        <polygon points="100,10 40,198 190,78 10,78 160,198"
        style="fill:orange;stroke:black;stroke-width:5;fill-rule:evenodd;" />
    </svg>
    <svg width="300" height="200">
        <polygon points="100,10 40,198 190,78 10,78 160,198"
        style="fill:yellow;stroke:black;stroke-width:5;fill-rule:evenodd;" />
    </svg> 
    <svg width="290" height="200">
        <polygon points="100,10 40,198 190,78 10,78 160,198"
        style="fill:lime;stroke:black;stroke-width:5;fill-rule:evenodd;" />
    </svg> 
    <svg width="300" height="200">
        <polygon points="100,10 40,198 190,78 10,78 160,198"
        style="fill:cyan;stroke:black;stroke-width:5;fill-rule:evenodd;" />
    </svg> 

    </section><!-- End -->
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