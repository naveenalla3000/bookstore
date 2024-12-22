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
  $select = $conn->prepare("SELECT * FROM categories WHERE id = :id");
  $select->execute([
    ":id" => $id
  ]);
  $image = $select->fetch(PDO::FETCH_OBJ);
  unlink("../../images/" . $image->image);

  $delete = $conn->prepare("DELETE FROM categories WHERE id = :id");
  $delete->execute([
    ":id" => $id
  ]);
  header("location: " . ADMINURL . "/categories-admins/show-categories.php");
}
?>

<?php require "../includes/footer.php"; ?>