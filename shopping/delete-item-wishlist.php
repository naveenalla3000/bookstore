<?php
require "../includes/header.php";
require "../config/config.php";
?>

<?php
/* at the top of 'check.php' */
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    /* 
       Up to you which header to send, some prefer 404 even if 
       the files does exist for security
    */
    header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
    die(header('location: ' . APPURL . ''));
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
if ($user_id == '') {
  header("location: " . APPURL . "");
}

if (isset($_POST["delete"])) {
    $id = $_POST["id"];
    try {
        $delete = $conn->prepare("DELETE FROM wishlist WHERE id = :id");
        $delete->execute([
            ":id" => $id,
        ]);
    } catch (PDOException $e) {
        echo $e->getMessage();
        die();
    }
}
?>
<?php require "../includes/footer.php"; ?>