<?php
require "includes/header.php";
require "../config/config.php";
?>

<?php
if (!isset($_SESSION['adminname'])) {
  header("location: " . ADMINURL . "/admins/login-admins.php");
}

$stmt1 = $conn->prepare("SELECT COUNT(*) AS admin_count FROM admins");
$stmt1->execute();
$admin_count = $stmt1->fetch(PDO::FETCH_OBJ);

$stmt2 = $conn->prepare("SELECT COUNT(*) AS product_count FROM products");
$stmt2->execute();
$product_count = $stmt2->fetch(PDO::FETCH_OBJ);

$stmt3 = $conn->prepare("SELECT COUNT(*) AS category_count FROM categories");
$stmt3->execute();
$category_count = $stmt3->fetch(PDO::FETCH_OBJ);

?>
<div class="container-fluid">

  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Products</h5>
          <!-- <h6 class="card-subtitle mb-2 text-muted">Bootstrap 4.0.0 Snippet by pradeep330</h6> -->
          <p class="card-text">number of products:
            <?php echo $product_count->product_count; ?>
          </p>

        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Categories</h5>
          <p class="card-text">number of categories:
            <?php echo $category_count->category_count; ?>
          </p>

        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Admins</h5>

          <p class="card-text">number of admins:
            <?php echo $admin_count->admin_count; ?>
          </p>

        </div>
      </div>
    </div>
  </div>


</div>
<?php require "includes/footer.php"; ?>