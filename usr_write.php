<?php
session_start();
require_once 'functions.php';

if (!is_logged_in()) {
    header("Location: login.php");
    die;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $genre = $_POST['genre'];
    $content = $_POST['review'];
    $rating = (int) $_POST['rating'];
    $userId = $_SESSION['SES']['id'];
    
    $albumId = create_album($title, $artist, $genre);
    $isApproved = create_review($albumId, $userId, $content, $rating);
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php include 'the_head.php'; ?>
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
                <ul>
                    <li><a href="index.php">ACASĂ</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>
        </div>
    </header>
    
    <section id="contact" class="contact">
    <div class="login-container">
        <div class="container">
            <div class="section-header">
                <h3 class="section-title">SCRIE UN REVIEW</h3>
                <p class="section-description">Fii concret, respectuos și evită recenziile track-by-track:</p>
            </div>
        </div>
        <form action="usr_write.php" method="post">
            <label for="title">Cum se numește albumul?</label><br>
            <input type="text" id="title" name="title" required><br><br>

            <label for="artist">Cum se numește artistul?</label><br>
            <input type="text" id="artist" name="artist" required><br><br>

            <label for="genre">Gen muzical?</label><br>
            <input type="text" id="genre" name="genre" required><br><br>

            <label for="review">Conținut:</label><br>
            <textarea id="review" name="review" rows="10" cols="50" required></textarea><br><br>

            <label for="rating">Notă (1-5):</label><br><br>
            <input type="number" id="rating" name="rating" min="1" max="5" required><br><br>

            <button type="submit" name="submit" onclick="window.location.href = 'index.php';">Trimite review-ul la verificare</button>
        </form>
    </div>
    </section>
</body>
</html>