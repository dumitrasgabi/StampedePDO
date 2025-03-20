<?php
session_start();
require_once 'functions.php';

if (!is_admin_logged_in()) {
    header("Location: login.php");
    die;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['review_id'])) {
    $review_id = (int)$_POST['review_id'];
    $query = "UPDATE reviews SET approved = 1 WHERE id = ?";
    
    $stmt = $con->prepare($query);
    $stmt->execute([$review_id]);

    header("Location: adm_held.php?message=review_approved");
    exit();
}
