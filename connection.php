<?php
    $dbms = 'mysql';
    $host = 'mysql_db';
    $db = 'rememberme_db';
    $user = 'root';
    $pass = 'toor';
    $dsn = "$dbms:host=$host;dbname=$db";
    $con = new PDO($dsn,  $user,$pass);
?>