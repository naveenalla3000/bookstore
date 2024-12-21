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
    $secret_key = "sk_test_51OQazASIurIjoMndaaQjFuR5120cyiyDBhO2VV5cTwRmPMDJDm1zWFaEE99aFzZwmh8KW3QC7pqKk9NOqLiortz900H5brRprp";
?>  