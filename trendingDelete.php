<?php
session_start();
require 'functions.php';
require_once 'triggerDelete.php';

#=================================================#

$sql1 = "DROP PROCEDURE IF EXISTS trendingDelete";
$sql2 = "CREATE PROCEDURE trendingDelete(IN intID INT)
BEGIN
    DELETE FROM trending_reviews WHERE id = intID;
END";

$stmt1 = $con -> prepare($sql1);
$stmt1 -> execute();

$stmt2 = $con -> prepare($sql2);
if (!$stmt2 -> execute()) {
    $_SESSION['error_message'] = "Eroare la crearea procedurii. <br>";
    header("Location: trendingGet.php");
    exit();
}

#=================================================#

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_review'])) {

    $id = $_POST['id_review'];
    $sql = "CALL trendingDelete('{$id}')";
    $q = $con -> query($sql);

    if ($q) {
        $_SESSION['success_message'] = "Review șters cu succes. ";
    } else {
        $_SESSION['error_message'] = "Eroare la ștergerea review-ului.";
    }

    header("Location: trendingGet.php");
    exit();

} else {

    $_SESSION['error_message'] = "Request invalid.";
    header("Location: trendingGet.php");
    exit();
}
