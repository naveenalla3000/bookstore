<?php
require "../../config/config.php";
require "../includes/header.php";

if (!isset($_SESSION['adminname'])) {
  header("location: " . ADMINURL . "/admins/login-admins.php");
  exit();
}

$select = $conn->prepare("SELECT * FROM categories");
$select->execute();
$allCategories = $select->fetchAll(PDO::FETCH_OBJ);

if (isset($_POST['submit'])) {
  $name = htmlspecialchars(trim($_POST['name']));
  $description = htmlspecialchars(trim($_POST['description']));
  $price = htmlspecialchars(trim($_POST['price']));
  $category_id = htmlspecialchars(trim($_POST['category_id'])); // Handle category selection

  // Validate inputs
  if (empty($name) || empty($description) || empty($price) || empty($category_id) || $category_id == "--select category--") {
    echo "<script>alert('Please fill all fields.')</script>";
  } else {
    $image = null;
    $file = null;

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
      $image = $_FILES['image']['name'];
      $targetImage = "../../images/" . basename($image);

      if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetImage)) {
        echo "<script>alert('Failed to upload image.')</script>";
        $image = null; // Set to null if upload fails
      }
    }

    // Handle file upload
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
      $file = $_FILES['file']['name'];
      $targetFile = "../../books/" . basename($file);

      if (!move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
        echo "<script>alert('Failed to upload file.')</script>";
        $file = null; // Set to null if upload fails
      }
    }

    // Insert into database if both uploads are successful or not required
    if ($image !== null && $file !== null) {
      $stmt = $conn->prepare("INSERT INTO products (name, description, price, category_id, image, file) VALUES (:name, :description, :price, :category_id, :image, :file)");
      $stmt->execute([
        ':name' => $name,
        ':description' => $description,
        ':price' => $price,
        ':category_id' => $category_id,
        ':image' => $image,
        ':file' => $file,
      ]);

      header("location: " . ADMINURL . "/products-admins/show-products.php");
      exit();
    } else {
      echo "<script>alert('Failed to upload required files.')</script>";
    }
  }
}
?>
<div class="container-fluid">
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title mb-5 d-inline">Create Products</h5>
          <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
            <!-- Name input -->
            <div class="form-outline mb-4 mt-4">
              <label>Name</label>
              <input type="text" name="name" class="form-control" placeholder="name" />
            </div>

            <!-- Price input -->
            <div class="form-outline mb-4 mt-4">
              <label>Price</label>
              <input type="text" name="price" class="form-control" placeholder="price" />
            </div>

            <!-- Description input -->
            <div class="form-group">
              <label for="exampleFormControlTextarea1">Description</label>
              <textarea name="description" placeholder="description" class="form-control" rows="3"></textarea>
            </div>

            <!-- Category select -->
            <div class="form-group">
              <label for="exampleFormControlSelect1">Select Category</label>
              <select name="category_id" class="form-control">
                <option>--select category--</option>
                <?php foreach ($allCategories as $category) : ?>
                  <option value="<?php echo $category->id; ?>">
                    <?php echo $category->name; ?>
                </option>
              <?php endforeach; ?>
              </select>
            </div>

            <!-- Image input -->
            <div class="form-outline mb-4 mt-4">
              <label>Image</label>
              <input type="file" name="image" class="form-control" placeholder="image" />
            </div>

            <!-- File input -->
            <div class="form-outline mb-4 mt-4">
              <label>File</label>
              <input type="file" name="file" class="form-control" placeholder="file" />
            </div>

            <!-- Submit button -->
            <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">Create</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require "../includes/footer.php"; ?>
