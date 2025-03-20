<?php
session_start();
require 'functions.php';

if (!is_logged_in() && !is_admin_logged_in()) {
    header("Location: login.php");
    die;
} else {
    if (is_admin_logged_in()) {
        header("Location: adm_index.php");
        exit();
    }
}

$trending_reviews = query("SELECT * FROM trending_reviews");

$background_image = 'assets/img/call-3.png';
if (isset($_SESSION['selected_image'])) {
    $selected_image = $_SESSION['selected_image'];
    $background_image = 'data:image/png;base64,' . base64_encode($selected_image);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'the_head.php'; ?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        #call-to-action {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('<?php echo $background_image; ?>') fixed center center;
            background-size: cover;
            padding: 80px 0;
        }
    </style>
</head>

<body>
    <header id="header" class="fixed-top d-flex align-items-center header-transparent">
        <div class="container d-flex justify-content-between align-items-center">

            <div id="logo">
                <a href="index.php"><img src="assets/img/logo.png" alt="Logo"></a>
            </div>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="#hero">Acasă</a></li>
                    <li><a class="nav-link scrollto " href="#portfolio">Review-uri în trending</a></li>
                    <li><a class="nav-link scrollto " href="#contact">Media</a></li>
                    <li><a href="usr_create.php">Creează un tabel în MySql</a></li>
                    <li><a href="usr_contact.php">Contact</a></li>
                    <li class="dropdown"><a href="#"><span> <?php echo htmlspecialchars($_SESSION['SES']['user_name']) ?> </span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="usr_write.php">Scrie un review</a></li>
                            <li><a href="usr_contact.php">Raportează o problemă</a></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                    <i class="bi bi-list mobile-nav-toggle"></i>
                </ul>
            </nav>
        </div>
    </header>

    <section id="hero">
        <div class="hero-container" data-aos="zoom-in" data-aos-delay="100">
            <h1> Bine ai revenit, <?php echo isset($_SESSION['SES']['user_name']) ? htmlspecialchars($_SESSION['SES']['user_name']) : 'Guest'; ?></h1>
            <h2> Citește sau scrie un review...</h2>
            <canvas id="canvas" width="150" height="150">Ora actuală</canvas> 
            <a href="#call-to-action" class="btn-get-started">Du-te jos</a>
        </div>
    </section>

    <main id="main">

        <section id="call-to-action">
            <div class="container">
                <div class="row" data-aos="zoom-in">
                    <div class="col-lg-9 text-center text-lg-start">
                        <h3 class="cta-title">La ce te gândești?</h3>
                        <p class="cta-text">Muzica e mai bună când o share-uiești cu alții. Ai vreun album să ne recomanzi?</p>
                    </div>
                    <div class="col-lg-3 cta-btn-container text-center">
                        <a class="cta-btn align-middle" href="usr_write.php">Scrie un review</a>
                    </div>
                </div>
            </div>
        </section>

        <section id="portfolio" class="portfolio">
            <div class="container" data-aos="fade-up">
                <div class="section-header">
                    <h3 class="section-title">Review-uri în trending</h3>
                    <p class="section-description">Citește niște review-uri proaspete scrise de comunitate!</p>
                </div>
                <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
                    <?php foreach ($trending_reviews as $review): ?>
                        <div class="col-lg-4 col-md-6 portfolio-item">
                            <a href="usr_more.php"></a>
                            <img src="<?php echo htmlspecialchars($review['image']); ?>" class="img-fluid" alt="">
                            <div class="portfolio-info">
                                <h4><?php echo htmlspecialchars($review['artist']) . ' - ' . htmlspecialchars($review['title']); ?></h4>
                                <p>de <?php echo htmlspecialchars($review['author']); ?></p>
                                <a href="usr_more.php">
                                    <i class="bx bx-show"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="call-to-action">
            <div class="container">
                <div class="row" data-aos="zoom-in">
                    <div class="col-lg-9 text-center text-lg-start">
                        <h3 class="cta-title">Vrei să citești mai multe review-uri?</h3>
                        <p class="cta-text">Acestea sunt doar niște aperitive. Scrie un review blană și poți ajunge și tu pe acest perete timp de o săptămână!</p>
                    </div>
                    <div class="col-lg-3 cta-btn-container text-center">
                        <a class="cta-btn align-middle" href="usr_more.php">Mai multe review-uri</a>
                    </div>
                </div>
            </div>
        </section>

        <section id="contact" class="contact">
            <div class="container">
                <div class="section-header">
                    <h3 class="section-title">Dă-ne un Subscribe pe YouTube</h3>
                    <p class="section-description">Mark l-a intervievat pe Rob Halford! Ascultă podcast-ul!</p>
                </div>
            </div>
        </section>

        <section id="call-to-action">
            <div class="kontainer">
                <iframe width="560" height="315"
                    src="https://www.youtube.com/embed/92unaedbbBA?si=h2-SUsidyFx5AY1M" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                <iframe width="560" height="315"
                    src="https://www.youtube.com/embed/ZmWbjtkxdW0?si=WhVdL1KVbVtFMCQC" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </section>

        <section id="call-to-action">
            <div class="kontainer">
                <div class="video-kontainer">
                    <video width="560" height="315" controls>
                        <source src="assets/img/nebuwed.mp4" type="video/mp4">
                        Browser-ul tău nu suportă video tag.
                    </video>
                </div>
                <div class="audio-kontainer">
                    <audio controls>
                        <source src="assets/img/nebunu.mp3" type="audio/mpeg">
                        Browser-ul tău nu suportă elemente audio.
                    </audio>
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
    <script src="assets/js/canvas.js"></script>
</body>

</html>
