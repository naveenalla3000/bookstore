<?php
require "../includes/header.php";
require "../config/config.php";
?>

<?php
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