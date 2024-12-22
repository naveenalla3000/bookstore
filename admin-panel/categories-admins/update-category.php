<?php
require "../includes/header.php";
require "../../config/config.php";
?>
<?php

if (!isset($_SESSION['adminname'])) {
  header("location: " . ADMINURL . "/admins/admins-login.php");
}

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $stmt = $conn->prepare("SELECT * FROM categories WHERE id = :id");
  $stmt->execute([
    ":id" => $id
  ]);
  $category = $stmt->fetch(PDO::FETCH_OBJ);
}
if (isset($_POST['submit'])) {
  $name = htmlspecialchars(trim($_POST['name']));
  $description = htmlspecialchars(trim($_POST['description']));
  // delete the old image
  $select = $conn->prepare("SELECT * FROM categories WHERE id = :id");
  $select->execute([
    ":id" => $id
  ]);
  $image = $select->fetch(PDO::FETCH_OBJ);
  unlink("../../images/" . $image->image);

  if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $image = $_FILES['image']['name'];
    $targetFile = "../../images/" . basename($image);

    if (empty($name) || empty($description) || empty($image)) {
      echo "<script>alert('Please fill all fields.')</script>";
    } else {
      // Move uploaded file to the target directory
      if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        $stmt = $conn->prepare("UPDATE categories SET name = :name, description = :description, image = :image WHERE id = :id");
        $stmt->execute([
          ':name' => $name,
          ':description' => $description,
          ':image' => $image,
          ':id' => $id,
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
          <h5 class="card-title mb-5 d-inline">Update Categories</h5>
          <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?id=" . $id; ?>" enctype="multipart/form-data">
            <div class="form-outline mb-4 mt-4">
              <input type="text" name="name" id="form2Example1" class="form-control" placeholder="name" value="<?php echo $category->name; ?>" />
            </div>
            <!-- Description input -->
            <div class="form-group">
              <label for="exampleFormControlTextarea1">Description</label>
              <textarea name="description" placeholder="description" class="form-control" rows="3">
                <?php echo trim($category->description); ?>
              </textarea>
            </div>
            <!-- Image upload -->
            <div class="form-outline mb-4 mt-4">
              <label>Image</label>
              <img src="../../images/<?php echo $category->image; ?>" alt="" width="800" height="450" />
              <input type="file" name="image" class="form-control" placeholder="image" value="<?php echo $category->image; ?>" />
            </div>
            <!-- Submit button -->
            <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">update</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require "../includes/footer.php"; ?>