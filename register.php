<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'the_head.php'; ?>
    <style>
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- ==== Logo === -->
        <div id="logo">
            <a href="login.php"><img src="assets/img/blue-logo.png" alt=""></a>
        </div>
    </div>
</header>

<section id="contact">
    <div class="login-container">
        <div class="container">
            <?php
                if (isset($_SESSION['error_message'])) {
                echo '<div class="error">' . $_SESSION['error_message'] . '</div>';
                unset($_SESSION['error_message']);
                }
                if (isset($_SESSION['success_message'])) {
                    echo '<div class="success">' . $_SESSION['success_message'] . '</div>';
                    unset($_SESSION['success_message']);
                }
            ?>
            <form id="registrationForm" action="process_registration.php" method="post">
                <div class="section-header">
                    <h3 class="section-title">CREEAZĂ UN CONT</h3><br><br><br><br>
                </div>
                <label for="username">Nume de utilizator (Doar litere și numere):</label>
                <input type="text" id="user_name" name="user_name" required>
                <span class="error" id="usernameError"></span>
                <br><br><br><br>
                <label for="password">Parolă (Minim 8 caractere):</label>
                <input type="password" id="password" name="password" required>
                <span class="error" id="passwordError"></span>
                <br><br><br><br><br>
                <button type="submit">Creează cont</button>
                <br><br><br><br>
            </form>
        </div>
    </div>
</section>

</body>

<script src="assets/js/register.js"></script>

</body>
</html>
