<?php
require "../includes/header.php";
require "../../config/config.php";

if (!isset($_SESSION['adminname'])) {
  header("location: " . ADMINURL . "/admins/admins-login.php");
  exit();
}

if (isset($_POST['submit'])) {
  $name = htmlspecialchars(trim($_POST['name']));
  $description = htmlspecialchars(trim($_POST['description']));

  if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $image = $_FILES['image']['name'];
    $targetFile = "../../images/" . basename($image);

    if (empty($name) || empty($description) || empty($image)) {
      echo "<script>alert('Please fill all fields.')</script>";
    } else {
      // Move uploaded file to the target directory
      if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        $stmt = $conn->prepare("INSERT INTO categories (name, description, image) VALUES (:name, :description, :image)");
        $stmt->execute([
          ':name' => $name,
          ':description' => $description,
          ':image' => $image,
        ]);

        header("location: " . ADMINURL . "/categories-admins/show-categories.php");
        exit();
      } else {
        echo "<script>alert('Failed to upload image.')</script>";
      }
    }
  } else {
    echo "<script>alert('Please upload an image.')</script>";
  }
}
?>
<div class="container-fluid">
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title mb-5 d-inline">Create Categories</h5>
          <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
            <!-- Name input -->
            <div class="form-outline mb-4 mt-4">
              <label>Name</label>
              <input type="text" name="name" class="form-control" placeholder="name" />
            </div>
            <!-- Description input -->
            <div class="form-group">
              <label for="exampleFormControlTextarea1">Description</label>
              <textarea name="description" placeholder="description" class="form-control" rows="3"></textarea>
            </div>
            <!-- Image upload -->
            <div class="form-outline mb-4 mt-4">
              <label>Image</label>
              <input type="file" name="image" class="form-control" placeholder="image" />
            </div>
            <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">Create</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
require "../includes/footer.php";
?>