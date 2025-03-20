<?php
session_start();
require 'functions.php';
require_once 'triggerInsert.php';

$allowed = ['image/jpeg', 'image/png', 'image/gif'];
$max = 40 * 1024 * 1024;

if (!is_admin_logged_in()) {
    header("Location: login.php");
    die;
}

#=================================================#

$sql1 = "DROP PROCEDURE IF EXISTS trendingInsert";
$sql2 = "CREATE PROCEDURE trendingInsert(
    IN strArtist varchar(255),
    IN strTitle varchar(255),
    IN strAuthor varchar(255),
    IN strImagePath varchar(255)
)
BEGIN
    INSERT INTO trending_reviews (artist, title, author, image) 
    VALUES (strArtist, strTitle, strAuthor, strImagePath);
END";

$stmt1 = $con -> prepare($sql1);
$stmt2 = $con -> prepare($sql2);

$stmt1 -> execute();
$stmt2 -> execute();

#=================================================#

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $type = $_FILES['image']['type'];
    $size = $_FILES['image']['size'];

    if (!in_array($type, $allowed)) {
        $_SESSION['error_message'] = "Ceva nu a mers bine.";
    } elseif ($size > $max) {
        $_SESSION['error_message'] = "Selectati o imagine mai mica de 40 MB.";
    } else {
        $director = "assets/img/portfolio/";
        $fisier = $director . basename($_FILES["image"]["name"]);
        $ok = 1;
        $tip_imagine = strtolower(pathinfo($fisier, PATHINFO_EXTENSION));

        $verif = getimagesize($_FILES["image"]["tmp_name"]);
        if ($verif !== false) {
            $ok = 1;
        } else {
            $ok = 0;
            $_SESSION['error_message'] = "Fisierul nu este o imagine.";
        }

        if ($ok == 0) {
            $_SESSION['error_message'] = "Ceva nu a mers bine.";
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $fisier)) {
                $artist = $_POST['artist'];
                $title = $_POST['title'];
                $author = $_POST['author'];
                $img_path = $fisier;

                $sql = "CALL trendingInsert('{$artist}', '{$title}', '{$author}', '{$img_path}')";
                $q = $con -> query($sql);

                if ($q) {
                    $_SESSION['success_message'] = "Succes la salvarea albumului. ";
                } else {
                    $_SESSION['error_message'] = "Eroare la salvare. ";
                }
            } else {
                $_SESSION['error_message'] = "Ceva nu a mers bine.";
            }
        }
    }

    header("Location: adm_index.php");
    exit();
}
?>