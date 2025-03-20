<?php
require 'functions.php';

#=================================================#

$sql1 = "DROP PROCEDURE IF EXISTS trendingGet";

$sql2 = "CREATE PROCEDURE trendingGet()
BEGIN
    SELECT id, artist, title, author, image FROM trending_reviews;
END";

$stmt1 = $con->prepare($sql1);
$stmt2 = $con->prepare($sql2);

$stmt1->execute();
$stmt2->execute();

#=================================================#

$sql3 = "CALL trendingGet()";
$q = $con -> query($sql3);
$q -> setFetchMode(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <?php include 'the_head.php'; ?>
    <title>Adaugă un album pe perete</title>
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
            <a href="adm_index.php"><img src="assets/img/blue-logo.png" alt=""></a>
        </div>
        <nav id="navbar" class="navbar">
            <ul><li><a href="adm_index.php">ÎNAPOI LA PAGINA DE ADMIN</a></li></ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
    </div>
</header>

<section id="contact">
    <div class="login-container">
        <div class="container">
            <div class="section-header">
                <h3 class="section-title">MODIFICĂ PERETELE</h3>
                <p class="section-description">Albumele de pe perete care se află în trending pot fi schimbate:</p>
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
            <form action="trendingInsert.php" method="post" enctype="multipart/form-data">
                <label for="artist">Artist:</label><br>
                <input type="text" name="artist" required><br>
                <label for="title">Album:</label><br>
                <input type="text" name="title" required><br>
                <label for="author">Autor:</label><br>
                <input type="text" name="author" required><br><br><br>
                <label for="image">Imagine:</label><br><br><br>
                <input type="file" name="image" id="image" accept="image/jpeg, image/png, image/gif" required><br><br><br>
                <button type="submit" class="btn-get-started">Încarcă</button><br><br>
            </form>

        <h2>Imagini valabile</h2>
            <div class="image-gallery">
            <?php while($img = $q -> fetch()): ?>
            <div class="image-item">
            <img src="<?php echo $img['image']; ?>" alt="<?php echo htmlspecialchars($img['image']); ?>" class="img-fluid">
        <form action="trendingUpdate.php" method="post" enctype="multipart/form-data">
            <br><br>
            <label for="id_review">ID-ul Review-ului:</label>
            <input type="text" name="id_review" value="<?php echo $img['id']; ?>">
            <label for="artist">Artist Nou:</label>
            <input type="text" name="artist" value="<?php echo htmlspecialchars($img['artist']); ?>"><br>
            <label for="title">Titlu Nou:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($img['title']); ?>"><br>
            <label for="author">Autor Nou:</label>
            <input type="text" name="author" value="<?php echo htmlspecialchars($img['author']); ?>"><br>
            <label for="image">Imagine Nouă:</label>
            <input type="file" name="image"><br><br>
            <button type="submit" class="btn-get-started">Modifică</button>
        </form>
        <form action="trendingDelete.php" method="post">
            <input type="hidden" name="id_review" value="<?php echo $img['id']; ?>"><br><br>
            <button type="submit" class="btn-get-started">Șterge</button><br>
        </form>
        <br><br>
        </div>
        <?php endwhile;?>
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
