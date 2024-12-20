<?php
require "../includes/header.php";
require "../config/config.php";
?>

<?php
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