<?php
require "../includes/header.php";
require "../config/config.php";
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
if ($user_id == '') {
  header("location: " . APPURL . "");
}

header("Refresh: 5; url=" . APPURL);

?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h1>Success</h1>
      <p>Your payment was successful!</p>
      <a href="<? echo APPURL; ?>" class="btn btn-primary">Download</a>
    </div>
  </div>
</div>

<?php require "../includes/footer.php"; ?>