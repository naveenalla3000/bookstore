<?php
require "../includes/header.php";
require "../config/config.php";
?>


<?php
/* at the top of 'check.php' */
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    /* 
     Up to you which header to send, some prefer 404 even if 
     the files does exist for security
  */
    header("Location: " . APPURL . " ");
    die;
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
if ($user_id == '') {
  header("location: " . APPURL . "");
}

if (isset($_POST["delete"])) {
    try {
        $deleteAll = $conn->prepare("DELETE FROM cart WHERE user_id=:user_id");
        $deleteAll->execute([
            ":user_id" => $_SESSION["user_id"],
        ]);
    } catch (PDOException $e) {
        echo $e->getMessage();
        die();
    }
}
?>


<?php
require "../includes/footer.php";
?>