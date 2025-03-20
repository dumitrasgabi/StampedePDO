<?php
session_start();
require 'functions.php';
require_once 'triggerUpdate.php';

#=================================================#

$sql1 = "DROP PROCEDURE IF EXISTS trendingUpdate";
$sql2 = "CREATE PROCEDURE trendingUpdate(
    IN intID INT,
    IN strArtist varchar(255),
    IN strTitle varchar(255),
    IN strAuthor varchar(255),
    IN strImage varchar(255)
)
BEGIN
    UPDATE trending_reviews 
    SET artist = strArtist, title = strTitle, author = strAuthor, image = strImage 
    WHERE id = intID;
END";

$stmt1 = $con->prepare($sql1);
$stmt2 = $con->prepare($sql2);

$stmt1->execute();
$stmt2->execute();

#=================================================#

$allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_review'])) {
    $id = $_POST['id_review'];
    $artist = $_POST['artist'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $image = '';

    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $type = $_FILES['image']['type'];

        if (!in_array($type, $allowed)) {
            $_SESSION['error_message'] = "Fila invalida.";
            header("Location: trendingGet.php");
            exit();
        }

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
                $image = $fisier;
            } else {
                $_SESSION['error_message'] = "Ceva nu a mers bine.";
            }
        }
    }

    if ($image) {
        $sql = "CALL trendingUpdate('{$id}', '{$artist}', '{$title}', '{$author}', '{$image}')";
    } else {
        $sql = "CALL trendingUpdate('{$id}', '{$artist}', '{$title}', '{$author}', '')";
    }
    $q = $con -> query($sql);

    if ($q) {
        $_SESSION['success_message'] = "Succes la modificarea albumului.";
    } else {
        $_SESSION['error_message'] = "Eroare la modificarea albumului.";
    }

    header("Location: trendingGet.php");
    exit();
} else {
    $_SESSION['error_message'] = "Request invalid.";
    header("Location: trendingGet.php");
    exit();
}
