<?php
require "../includes/header.php";
require "../../config/config.php";
?>
<?php

if (!isset($_SESSION['adminname'])) {
  header("location: " . ADMINURL . "");
}

if (htmlspecialchars($_SERVER['REQUEST_METHOD']) == 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $adminname = $_POST['username'];
  if (empty($email) || empty($password) || empty($adminname)) {
    echo "<script>alert('one or more inputs are empty')</script>";
  } else {
    $admin = $conn->prepare("INSERT INTO admins (email, adminname, password) VALUES (:email, :adminname, :password)");
    $admin->execute([
      ':email' => $email,
      ':adminname' => $adminname,
      ':password' => password_hash($password, PASSWORD_DEFAULT),
    ]);
    header("location: " . ADMINURL . "/admins/admins.php");
  }
}

?>
<div class="container-fluid">
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title mb-5 d-inline">Create Admins</h5>
          <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <!-- Email input -->
            <div class="form-outline mb-4 mt-4">
              <input type="email" name="email" id="form2Example1" class="form-control" placeholder="email" />

            </div>

            <div class="form-outline mb-4">
              <input type="text" name="username" id="form2Example1" class="form-control" placeholder="username" />
            </div>
            <div class="form-outline mb-4">
              <input type="password" name="password" id="form2Example1" class="form-control" placeholder="password" />
            </div>

            <!-- Submit button -->
            <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>


          </form>

        </div>
      </div>
    </div>
  </div>
</div>
<?php
require "../includes/footer.php";
?>