<?php
require "../includes/header.php";
require "../config/config.php";
?>

<?php
/* at the top of 'check.php' */
if(!isset($_SERVER['HTTP_REFERER'])){
    header("location: cart.php");
    exit;
  }

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
if ($user_id == '') {
  header("location: " . APPURL . "");
}

if (isset($_POST["delete"])) {
    $id = $_POST["id"];
    try {
        $delete = $conn->prepare("DELETE FROM cart WHERE id = :id");
        $delete->execute([
            ":id" => $id,
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