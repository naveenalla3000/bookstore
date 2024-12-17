<?php
    $host = "localhost";
    $dbname = "bookstore";
    $dbuser = "root";
    $dbpassword = "";
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpassword);
    $conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>  