<?php
require "../includes/header.php";
require "../../config/config.php";
?>
<?php
if (!isset($_SESSION['adminname'])) {
    header("location: " . ADMINURL . "/admins/login-admins.php");
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    echo $id;
    $select = $conn->prepare("SELECT * FROM products WHERE id = :id");
    $select->execute([
        ":id" => $id
    ]);
    $product = $select->fetch(PDO::FETCH_OBJ);
    unlink("../../images/" . $product->image);
    unlink("../../books/" . $product->file);

    $delete = $conn->prepare("DELETE FROM products WHERE id = :id");
    $delete->execute([
        ":id" => $id
    ]);
    header("location: " . ADMINURL . "/products-admins/show-products.php");
}
?>

<?php require "../includes/footer.php"; ?>