<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php
if (!isset($_GET['id'])) {
    header("Location: " . APPURL . "");
}
$id = $_GET['id']; // Ensure proper validation and sanitization for $_GET['id']

// Prepare the query
$rows = $conn->prepare("SELECT * FROM products WHERE status = 1 AND category_id = :category_id");

// Execute the query with parameter binding
$rows->execute([
    ":category_id" => $id,
]);

// Fetch all results as objects
$allRows = $rows->fetchAll(PDO::FETCH_OBJ);

?>

<div class="container">
    <div class="row mt-5">
        <?php foreach ($allRows as $product) : ?>
            <div class="col-lg-4 col-md-6 col-sm-10 offset-md-0 offset-sm-1 mb-5">
                <div class="card">
                    <a href="<?php echo APPURL . 'shopping/single.php?id=' . urlencode($product->id); ?>"><img height="213px" class="card-img-top" src="../images/<?php echo $product->image; ?>"></a>
                    <div class="card-body">
                        <h5 class="d-inline"><b><?php echo $product->name; ?></b> </h5>
                        <h5 class="d-inline">
                            <div class="text-muted d-inline">($<?php echo $product->price; ?>/item)</div>
                        </h5>
                        <p><?php echo substr($product->description, 0, 160); ?></p>
                        <a href="<?php echo APPURL . 'shopping/single.php?id=' . urlencode($product->id); ?>" class="btn btn-primary w-100 rounded my-2">
                            More <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <br>
        <?php endforeach; ?>
    </div>

</div>

<? require "../includes/footer.php"; ?>