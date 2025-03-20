<?php
session_start();
require_once 'functions.php';

if (!isset($_SESSION['ADMIN_SES']) || empty($_SESSION['ADMIN_SES']['aid'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_POST['review_id'])) {
    header("Location: adm_index.php");
    exit;
}


$reviewId = $_POST['review_id'];
$rejected = reject_review($reviewId);
header("Location: adm_held.php");
exit;
