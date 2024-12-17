<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php
    if (isset($_SESSION['user_id'])) {
        header("location: ".APPURL."");
    }
    if (htmlspecialchars($_SERVER['REQUEST_METHOD']) == 'POST') {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
        if (empty($email) or empty($password)) {
            echo "<script>alert('email and password fields should not be empty')</script>";
        } else {
            $login = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $login->bindParam(':email', $email, PDO::PARAM_STR);
            $login->execute();
            $fetch = $login->fetch(PDO::FETCH_ASSOC);
            if ($login->rowCount() > 0 AND password_verify($password, $fetch["password"])) {
                $_SESSION = array_merge($_SESSION, ['user_id' => $fetch['id'], 'username' => $fetch['username'], 'email' => $fetch['email']]);
                header("location: ".APPURL."");
            } else {
                echo "<script>alert('email or password is incorrect')</script>";
            }
        }
    }
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form class="form-control mt-5" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                <h4 class="text-center mt-3"> Login </h4>
                <div class="">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                    <div class="">
                        <input type="email" name="email" class="form-control" id="" value="">
                    </div>
                </div>
                <div class="">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                    <div class="">
                        <input type="password" name="password" class="form-control" id="inputPassword">
                    </div>
                </div>
                <button class="w-100 btn btn-lg btn-primary mt-4" name="login" type="submit">login</button>
            </form>
        </div>
    </div>



</div>
<?php require "../includes/footer.php"; ?>