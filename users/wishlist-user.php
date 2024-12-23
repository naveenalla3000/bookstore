<?php
require "../includes/header.php";
require "../config/config.php";
?>
<?php
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$rows = $conn->prepare("SELECT * FROM wishlist WHERE user_id = :user_id ");
$rows->execute([
    ":user_id" => $user_id,
]);
$allRows = $rows->fetchAll(PDO::FETCH_OBJ);
?>

<div class="container">
    <div class="row mt-5">
        <?php if (count($allRows) > 0) : ?>
            <?php foreach ($allRows as $product) : ?>
                <div class="col-lg-4 col-md-6 col-sm-10 offset-md-0 offset-sm-1 mb-5">
                    <div class="card">
                        <a href="<?php echo APPURL . 'shopping/single.php?id=' . urlencode($product->pro_id); ?>"><img height="213px" class="card-img-top" src="../images/<?php echo $product->pro_image ?>" alt="images/<?php echo $product->pro_image; ?>"></a>
                        <div class="card-body">
                            <h5 class="d-inline"><b><?php echo $product->pro_name; ?></b> </h5>
                            <h5 class="d-inline">
                                <div class="text-muted d-inline">($<?php echo $product->pro_price; ?>/item)</div>
                            </h5>
                            <a href="<?php echo APPURL . 'shopping/single.php?id=' . urlencode($product->pro_id); ?>" class="btn btn-primary w-100 rounded my-2">
                                More <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <br />
                </div>
                <br>
            <?php endforeach; ?>
        <?php else : ?>
            <h1>No items in your wishlist.</h1>
        <?php endif; ?>
    </div>
</div>

<?php require "../includes/footer.php"; ?>