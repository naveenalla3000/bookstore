<?php
require "../includes/header.php";
require "../config/config.php";
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
if (isset($_POST["submit"])) {
    $pro_id = $_POST["pro_id"];
    $pro_name = $_POST["pro_name"];
    $pro_image = $_POST["pro_image"];
    $pro_price = $_POST["pro_price"];
    $pro_amount = $_POST["pro_amount"];
    $pro_file = $_POST["pro_file"];
    $user_id = $_POST["user_id"];
    if (empty($user_id)) {
        header("Location: " . APPURL . "/auth/login.php");
        exit;
    }
    $insert = $conn->prepare("INSERT INTO cart (pro_id, pro_name, pro_image, pro_price, pro_amount, pro_file, user_id) VALUES (:pro_id, :pro_name, :pro_image, :pro_price, :pro_amount, :pro_file, :user_id)");
    try {
        $insert->execute([
            ":pro_id" => $pro_id,
            ":pro_name" => $pro_name,
            ":pro_image" => $pro_image,
            ":pro_price" => $pro_price,
            ":pro_amount" => $pro_amount,
            ":pro_file" => $pro_file,
            ":user_id" => $user_id,
        ]);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


$productId = urldecode($_GET['id']);
if ($productId) {
    try {
        $select = $conn->prepare("SELECT * FROM cart WHERE pro_id = :pro_id AND user_id = :user_id");
        $select->execute([
            ":pro_id" => $productId,
            ":user_id" => $user_id,
        ]);
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = :id AND status = 1");
        $stmt->bindParam(":id", $productId, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_OBJ);
        if (!$product) {
            header("HTTP/1.0 404 Not Found");
            echo "Product not found";
            exit;
        }
    } catch (PDOException $e) {
        error_log("Product fetch error: " . $e->getMessage());
        echo "An error occurred while fetching product details.";
        exit;
    }
} else {
    header("location: " . APPURL . "/404.php");
    echo "Invalid product ID";
    exit;
}
?>

<div class="container mt-5 mb-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="row">
                    <div class="col-md-6">
                        <div class="images p-3">
                            <div class="text-center p-4">
                                <img id="main-image" src="../images/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" width="250" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="product p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <a href="<?php echo APPURL; ?>" class="ml-1 btn btn-primary">
                                        <i class="fa fa-long-arrow-left"></i> Back
                                    </a>
                                </div>
                                <i class="fa fa-shopping-cart text-muted"></i>
                            </div>
                            <div class="mt-4 mb-3">
                                <h5 class="text-uppercase"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></h5>
                                <div class="price d-flex flex-row align-items-center">
                                    <span class="act-price">$<?php echo number_format($product->price, 2); ?></span>
                                </div>
                            </div>
                            <p class="about"><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></p>
                            <form method="post" id="form-data" action="">
                                <input type="hidden" name="pro_id" value="<?php echo htmlspecialchars($product->id, ENT_QUOTES, 'UTF-8'); ?>">
                                <input type="hidden" name="pro_name" value="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>">
                                <input type="hidden" name="pro_image" value="<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>">
                                <input type="hidden" name="pro_price" value="<?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?>">
                                <input type="hidden" name="pro_file" value="<?php echo htmlspecialchars($product->file, ENT_QUOTES, 'UTF-8'); ?>">
                                <?php if (isset($_SESSION['user_id'])) { ?>
                                    <div class="form-group">
                                        <label for="pro_amount">Quantity</label>
                                        <input type="number" name="pro_amount" id="pro_amount" class="form-control" value="1" min="1">
                                    </div>
                                <?php } ?>
                                <?php if (isset($_SESSION['user_id'])) :?>
                                    <input type="hidden" name="user_id" value="<?php echo  htmlspecialchars($_SESSION['user_id']) ?>">
                                <?php endif; ?>
                                <?php if (isset($_SESSION["user_id"])) { ?>
                                    <div class="cart mt-4 align-items-center">
                                        <?php if ($select->rowCount() > 0): ?>
                                            <button type="submit" id="submit" name="submit" disabled class="btn btn-primary text-uppercase mr-2 px-4">
                                                <i class="fas fa-shopping-cart"></i> Added to cart
                                            </button>
                                        <?php else: ?>
                                            <button type="submit" id="submit" name="submit" class="btn btn-primary text-uppercase mr-2 px-4">
                                                <i class="fas fa-shopping-cart"></i> Add to cart
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                <?php } ?>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php require "../includes/footer.php"; ?>

<script>
    $(document).ready(function() {
        $(document).on("submit", function(e) {
            e.preventDefault();
            var formdata = $("#form-data").serialize() + '&submit=submit';
            $.ajax({
                url: "single.php?id=<?php echo $productId; ?>",
                type: "POST",
                data: formdata,
                success: function(data) {
                    alert("Product added to cart");
                    $("#submit").html("<i class='fas fa-shopping-cart'></i> Add to cart").prop("disabled", true);
                    reload();
                },
                error: function(xhr, status, error) {
                    alert("An error occurred: " + xhr.responseText);
                }
            });
            function reload() {
                $("body").load("single.php?id=<?php echo $productId; ?>");
            }
        });
    });
</script>