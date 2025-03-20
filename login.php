<?php
session_start();
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $captcha = $_POST['g-recaptcha-response'];
    $secretKey = "6LeLneEpAAAAABMOeFx0_Ecdzq-i6RWIDcv7e4Xx";
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha);
    $responseKeys = json_decode($response, true);

    if (intval($responseKeys["success"]) !== 1) 
    {
        header("Location: login.php?error=Captcha verification failed");
        exit();
    }

    $remember = $_POST['remember'] ?? null;
    $iamadmin = $_POST['iamadmin'] ?? null;

    if ($iamadmin) {
        $admin_name = addslashes($_POST['admin_name']);
        $adminword = addslashes($_POST['adminword']);

        $admin_query = "SELECT * FROM admins WHERE admin_name = :admin_name AND adminword = :adminword LIMIT 1";
        $stmt = $con->prepare($admin_query);
        $stmt->bindParam(':admin_name', $admin_name, PDO::PARAM_STR);
        $stmt->bindParam(':adminword', $adminword, PDO::PARAM_STR);
        $stmt->execute();

        $admin_row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin_row) {
            $_SESSION['ADMIN_SES'] = $admin_row;
        
            if ($remember) {
                $expires = time() + (60 * 60 * 24 * 7);
                $salt = "*&salt#@";
                
                $admin_token_key = hash('sha256', time() . $salt);
                $admin_token_value = hash('sha256', 'Logged_in' . $salt);
        
                setcookie('ADMIN_SES', $admin_token_key . ':' . $admin_token_value, $expires, "/", "", false, true);
                
                $aid = $admin_row['aid'];
                $admin_update_query = "UPDATE admins SET admin_token_key = :admin_token_key, admin_token_value = :admin_token_value WHERE aid = :aid LIMIT 1";
                $stmt = $con->prepare($admin_update_query);
                $stmt->bindParam(':admin_token_key', $admin_token_key);
                $stmt->bindParam(':admin_token_value', $admin_token_value);
                $stmt->bindParam(':aid', $aid, PDO::PARAM_INT);
                $stmt->execute();
            }
        
            header("Location: adm_index.php");
            die;
        } else {
            $_SESSION['login_error'] = true;
            header("Location: login.php?error=Admin login failed");
            exit();
        }
    } else {
        $user_name = $_POST['user_name'];
        $password = $_POST['password'];

        $query = "SELECT * FROM users WHERE user_name = :user_name LIMIT 1";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($password, $row['password'])) {
            $_SESSION['SES'] = $row;

            if ($remember) {
                $expires = time() + (60 * 60 * 24 * 7); // o săpt
                $salt = "*&salt#@";
                
                $token_key = hash('sha256', time() . $salt);
                $token_value = hash('sha256', 'Logged_in' . time() . $salt);

                setcookie('SES', $token_key . ':' . $token_value, $expires, "/", "", false, true);
                
                $id = $row['id'];
                $user_update_query = "UPDATE users SET token_key = :token_key, token_value = :token_value WHERE id = :id LIMIT 1";
                $stmt = $con->prepare($user_update_query);
                $stmt->bindParam(':token_key', $token_key);
                $stmt->bindParam(':token_value', $token_value);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
            }
            header("Location: index.php");
            die;
        } else {
            $_SESSION['login_error'] = true;
            header("Location: login.php?error=User login failed");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <?php include 'the_head.php'; ?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        function toggleAdminFields() {
            var adminCheckbox = document.getElementById('iamadmin');
            var adminFields = document.getElementsByClassName('admin-fields');
            var userFields = document.getElementsByClassName('user-fields');
            var isAdmin = adminCheckbox.checked;
            for (var i = 0; i < adminFields.length; i++) {
                adminFields[i].style.display = isAdmin ? 'block' : 'none';
                adminFields[i].required = isAdmin;
            }
            for (var i = 0; i < userFields.length; i++) {
                userFields[i].style.display = isAdmin ? 'none' : 'block';
                userFields[i].required = !isAdmin;
            }
        }
    </script>
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
                <form method="post" id="login_form">
                    <div class="section-header">
                        <h3 class="section-title">INTRĂ ÎN CONT</h3><br>
                    </div>
                    <?php
                    if (isset($_SESSION['login_error']) && $_SESSION['login_error']) {
                        echo '<div id="error-message" class="error-message" style="display: block;">Wrong username or password</div>';
                        unset($_SESSION['login_error']);
                    }
                    ?>
                    <div class="user-fields">
                        <input type="text" name="user_name" placeholder="Username"><br><br>
                        <input type="password" name="password" placeholder="Password"><br><br>
                    </div>
                    <br>
                    <input type="checkbox" name="remember"> Ține-mă minte <br><br>
                    <input type="checkbox" name="iamadmin" id="iamadmin" onchange="toggleAdminFields()"> Sunt administrator <br><br>
                    <div class="admin-fields">
                        <input type="text" name="admin_name" placeholder="Admin Username"><br><br>
                        <input type="password" name="adminword" placeholder="Admin Password"><br><br>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="6LeLneEpAAAAAJsAyc2nDjIifCGlwRIhntWUJygQ"></div>
                        <span id="captcha_error" class="text-danger"></span>
                    </div>
                    <br><br>
                    <button type="submit">Autentificare</button>
                </form>
                <br><br><br><br>
                <div>
                    <p>Nu ai un cont? <a href="register.php">Înregistrează-te</a></p>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#login_form').on('submit', function(event) {
                if (grecaptcha.getResponse() === '') {
                    event.preventDefault();
                    $('#captcha_error').text('Please complete the CAPTCHA.');
                } else {
                    $('#captcha_error').text('');
                }
            });
            toggleAdminFields();
        });
    </script>
</body>
</html>
