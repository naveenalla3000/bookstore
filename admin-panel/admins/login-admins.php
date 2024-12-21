<?php 
require "../includes/header.php";
require "../../config/config.php";
?>
<?php
    if (isset($_SESSION['admin_id'])) {
        header("location: ".ADMINURL."");
    }
    if (htmlspecialchars($_SERVER['REQUEST_METHOD']) == 'POST') {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
        if (empty($email) or empty($password)) {
            echo "<script>alert('email and password fields should not be empty')</script>";
        } else {
            $login = $conn->prepare("SELECT * FROM admins WHERE email = :email");
            $login->bindParam(':email', $email, PDO::PARAM_STR);
            $login->execute();
            $fetch = $login->fetch(PDO::FETCH_ASSOC);
            if ($login->rowCount() > 0 AND password_verify($password, $fetch["password"])) {
                $_SESSION = array_merge($_SESSION, ['admin_id' => $fetch['id'], 'adminname' => $fetch['adminname'], 'email' => $fetch['email']]);
                $_SESSION['admin_id'] = $fetch['id'];
                $_SESSION['adminname'] = $fetch['adminname'];
                header("location: ".ADMINURL."");
            } else {
                echo "<script>alert('email or password is incorrect')</script>";
            }
        }
    }
?>
<div class="container-fluid"> 
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mt-5">Login</h5>
              <form method="POST" class="p-auto" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                  <!-- Email input -->
                  <div class="form-outline mb-4">
                    <input type="email" name="email" id="form2Example1" class="form-control" placeholder="Email" />
                   
                  </div>

                  
                  <!-- Password input -->
                  <div class="form-outline mb-4">
                    <input type="password" name="password" id="form2Example2" placeholder="Password" class="form-control" />
                    
                  </div>



                  <!-- Submit button -->
                  <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Login</button>

                 
                </form>

            </div>
       </div>
     </div>
    </div>
</div>
<?php
require "../includes/footer.php";
?>