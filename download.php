<?php
require "includes/header.php";
require "config/config.php";
?>

<?php
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id=:user_id");
    if ($stmt->execute([":user_id" => $user_id])) {
        $allProducts = $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}

require 'vendor/autoload.php';

use \SendGrid\Mail\Mail;

$email = new Mail();
$email->setFrom('naveenalla3000@gmail.com', 'Bookstore');
$email->setSubject('fucking bitches');
$email->addTo($_SESSION["email"], $_SESSION["username"]);
$email->addContent('text/html', '<strong>and fast with the PHP helper library.</strong>');



foreach ($allProducts as $product) {
    $path = "books/";
    $filePath = $path . $product->pro_file; // Access the property using object syntax
    if (file_exists($filePath)) { // Ensure the file exists before attaching
        echo "<pre>";
        echo "Attaching file: " . $filePath . "\n";
        $email->addAttachment(file_get_contents($filePath), "application/octet-stream", $product->pro_file);
    } else {
        echo "<pre>";
        echo "File does not exist: " . $filePath . "\n";
    }
}


$sendgrid = new \SendGrid("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");
try {
    $response = $sendgrid->send($email);
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = :user_id");
    $stmt->execute([
        ":user_id" => $user_id,
    ]);
    header("location: ".APPURL."shopping/success.php"); //
} catch (Exception $e) {
    error_log('Caught exception: ' . $e->getMessage()); 
}

?>
