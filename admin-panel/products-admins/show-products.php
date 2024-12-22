<?php require "../includes/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php

if (!isset($_SESSION['adminname'])) {
  header("location: " . ADMINURL . "/admins/login-admins.php");
  exit();
}
$select = $conn->query("SELECT * FROM products");
$select->execute();
$allProducts = $select->fetchAll(PDO::FETCH_OBJ);

$select = $conn->query("SELECT * FROM categories");
$select->execute();
$allCategories = $select->fetchAll(PDO::FETCH_OBJ);
// echo '<pre>';
// print_r($allCategories);
// echo '</pre>';
// echo '<pre>';
// print_r($allProducts);
// echo '</pre>';


?>

<div class="container-fluid">

  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title mb-4 d-inline">Products</h5>
          <a href="<?php echo ADMINURL; ?>/products-admins/create-products.php" class="btn btn-primary mb-4 text-center float-right">Create Products</a>

          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">product</th>
                <th scope="col">price in $$</th>
                <th scope="col">category</th>
                <th scope="col">status</th>
                <th scope="col">delete</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($allProducts as $product) : ?>
                <th scope="row">
                  <?php echo $product->id; ?>
                </th>
                <td>
                  <?php echo $product->name; ?>
                </td>
                <td>
                  <?php echo $product->price; ?>
                </td>
                <td>
                  <?php
                  echo getCategoryName($allCategories, $product->category_id);
                  ?>
                </td>
                <td><a href="
                <?php echo ADMINURL; ?>/products-admins/update-status.php?id=<?php echo $product->id; ?>
                " class="btn btn-success  text-center ">
                  <?php echo $product->status==1 ? 'available' : 'unavailable'; ?>
                </a></td>
                <td><a href="
                <?php echo ADMINURL; ?>/products-admins/delete-product.php?id=<?php echo $product->id; ?>
                " class="btn btn-danger  text-center ">delete</a></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
function getCategoryName($allCategories, $categoryId)
{
  foreach ($allCategories as $category) {
    if ($category->id == $categoryId) {
      return $category->name;
    }
  }
  return "No category";
}
?>
<?php require "../includes/footer.php"; ?>