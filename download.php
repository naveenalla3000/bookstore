<?php
require "includes/header.php";
require "config/config.php";
?>

<?php
if (!isset($_SERVER['HTTP_REFERER'])) {
    header("location: cart.php");
    exit;
}
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['id'];
    $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id=:user_id");
    if ($stmt->execute([":user_id" => $user_id])) {
        $allProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    $zipname = 'file.zip';
    $zip = new ZipArchive;
    $zip->open($zipname, ZipArchive::CREATE);
    foreach ($allProducts as $product) {
        $zip->addFile("books/" . $product->pro_file);
    }
    $zip->close();

    header('Content-Type: application/zip');
    header('Content-disposition: attachment; filename=' . $zipname);
    readfile($zipname);
}
