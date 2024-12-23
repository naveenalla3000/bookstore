<?php
require "../includes/header.php";
require "../config/config.php";
?>

<?php
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
if (isset($_POST["submit"])) {
    $pro_id = $_POST["pro_id"];
    $pro_name = $_POST["pro_name"];
    $pro_image = $_POST["pro_image"];
    $pro_price = $_POST["pro_price"];
    $pro_amount = $_POST["pro_amount"];
    $user_id = $_POST["user_id"];
    if (empty($user_id)) {
        header("Location: " . APPURL . "/auth/login.php");
        exit;
    }
    $insert = $conn->prepare("INSERT INTO wishlist (pro_id, pro_name, pro_image, pro_price, pro_amount, user_id) VALUES (:pro_id, :pro_name, :pro_image, :pro_price, :pro_amount, :user_id)");
    try {
        $insert->execute([
            ":pro_id" => $pro_id,
            ":pro_name" => $pro_name,
            ":pro_image" => $pro_image,
            ":pro_price" => $pro_price,
            ":pro_amount" => $pro_amount,
            ":user_id" => $user_id,
        ]);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>




<?php require "../includes/footer.php"; ?>