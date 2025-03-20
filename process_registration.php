<?php
session_start();
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['user_name'];
    $password = $_POST['password'];

    if (preg_match('/[^a-zA-Z0-9]/', $username)) {
        $_SESSION['error_message'] = "Username can only contain letters and numbers.";
        header("Location: register.php");
        exit;
    }

    if (strlen($password) < 8) {
        $_SESSION['error_message'] = "Password must be at least 8 characters long.";
        header("Location: register.php");
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        $query = "INSERT INTO users (user_name, password) VALUES (:username, :password)";
        $stmt = $con->prepare($query);
        $stmt->execute([
            ':username' => $username,
            ':password' => $hashed_password
        ]);

        $_SESSION['success_message'] = "Registration successful!";
        header("Location: register.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
        header("Location: register.php");
        exit;
    }
}
