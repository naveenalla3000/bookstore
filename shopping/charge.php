<?php
require "../includes/header.php";
require "../config/config.php";
require "../vendor/autoload.php";

/* at the top of 'check.php' from stackoverflow */ 
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    /* 
       Up to you which header to send, some prefer 404 even if 
       the files does exist for security
    */
    header("Location: " . APPURL . " ");
    die;
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
if ($user_id == '') {
  header("location: " . APPURL . "");
}

$stripe = new \Stripe\StripeClient($secret_key);

// Check if required fields and session variables are set
if (
    empty($_POST["email"]) || empty($_POST["username"]) ||
    empty($_POST["fname"]) || empty($_POST["lname"]) ||
    !isset($_SESSION["price"], $_SESSION["user_id"])
) {
    echo "<script>alert('All fields must be filled and session variables must be set.')</script>";
    exit();
}

$email = $_POST["email"];
$username = $_POST["username"];
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$price = $_SESSION["price"];
$user_id = $_SESSION["user_id"];

try {
    // Create a Stripe checkout session
    $session = $stripe->checkout->sessions->create([
        'line_items' => [
            [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Naveen alla PHP Application',
                    ],
                    'unit_amount' => $price, // Use price from session
                ],
                'quantity' => 1,
            ],
        ],
        'mode' => 'payment',
        'success_url' => "http://localhost/bookstore/download.php",
        'cancel_url' => "http://localhost/bookstore/shopping/cancel.php",
    ]);

    // Insert order into the database
    $stmt = $conn->prepare("INSERT INTO orders (email, username, fname, lname, token, price, user_id) VALUES 
        (:email, :username, :fname, :lname, :token, :price, :user_id)");
    $stmt->execute([
        ":email" => $email,
        ":username" => $username,
        ":fname" => $fname,
        ":lname" => $lname,
        ":token" => $session->id, // Use the Stripe session ID as the token
        ":price" => $price,
        ":user_id" => $user_id,
    ]);

    // Redirect to Stripe's hosted checkout page
    header("Location: " . $session->url);
    exit();
} catch (\Stripe\Exception\ApiErrorException $e) {
    echo "Error creating Stripe session: " . $e->getMessage();
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
