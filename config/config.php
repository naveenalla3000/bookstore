<?php
    $host = "localhost";
    $dbname = "bookstore";
    $dbuser = "root";
    $dbpassword = "";
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpassword,[
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_AUTOCOMMIT => true,
    ]);
    $conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>  