<?php
session_start();

if(!empty($_SESSION['SES'])) {
    unset($_SESSION['SES']);
    setcookie('SES','',time()-(3600), "/");
}

if(!empty($_SESSION['ADMIN_SES'])) {
    unset($_SESSION['ADMIN_SES']);
    setcookie('ADMIN_SES','',time()-(3600), "/");
}

header("Location: login.php");
exit();
