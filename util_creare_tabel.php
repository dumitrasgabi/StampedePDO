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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db_name = $_POST['db_name'];
    $columns = $_POST['columns'];
    
    if (empty($db_name) || empty($columns)) {
        $_SESSION['error_message'] = "Campurile obligatorii nu au fost completate.";
        header("Location: usr_create.php");
        exit();
    }

    $query = "CREATE TABLE $db_name ($columns)";

    try {
        $con->exec($query);
        $_SESSION['success_message'] = "Table $db_name created successfully.";
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Error creating table: " . $e->getMessage();
    }

    header("Location: usr_create.php");
    exit();
}
?>
