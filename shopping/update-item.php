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

if (isset($_POST["update"])) {
    $id = $_POST["id"];
    $pro_amount = $_POST["product_amount"];

    try {
        $update = $conn->prepare("UPDATE cart SET pro_amount = :product_amount WHERE id = :id");
        $update->execute([
            ":product_amount" => $pro_amount,
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