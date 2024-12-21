<?php
require "../includes/header.php";
require "../config/config.php";

/* at the top of 'check.php' from stackoverflow */ 
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    /* 
       Up to you which header to send, some prefer 404 even if 
       the files does exist for security
    */
    header("Location: " . APPURL . " ");
    die;
}
?>