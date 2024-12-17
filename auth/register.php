<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php
    if (isset($_SESSION['user_id'])) {
        header("location: ".APPURL."");
    }
    if (htmlspecialchars($_SERVER['REQUEST_METHOD']) == 'POST') {
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        if (empty($username) || empty($email) || empty($password)) {
            echo "<script>alert('username, email and password filds should not be empty')</script>";
        } else {
            $register = $conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            try {
                $register->execute([
                    ':username' => $username,
                    ':email' => $email,
                    ':password' => password_hash($password, PASSWORD_DEFAULT),
                ]);
                header("location: login.php");
            } catch (PDOException $e) {
                echo "<script>alert('username or email already exists')</script>";
            }
        }
    }
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form class="form-control mt-5" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                <h4 class="text-center mt-3"> Register </h4>
                <div class="">
                    <label for="" class="col-sm-2 col-form-label">Username</label>
                    <div class="">
                        <input type="text" name="username" class="form-control" id="" value="">
                    </div>
                </div>
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
                <button class="w-100 btn btn-lg btn-primary mt-4" type="submit" name="register">register</button>
            </form>
        </div>
    </div>
</div>

<?php require "../includes/footer.php"; ?>