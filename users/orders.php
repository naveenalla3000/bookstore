<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
if ($user_id == '') {
    header("location: " . APPURL . "");
}

$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = :user_id");
$stmt->execute([
    ":user_id" => $user_id,
]);
$allOrders = $stmt->fetchAll(PDO::FETCH_OBJ);

?>
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4 d-inline">Orders</h5>
                    <?php if (count($allOrders) <= 0) : ?>
                        <h3 class="text-center">No orders yet</h3>
                    <?php else : ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">username</th>
                                    <th scope="col">email</th>
                                    <th scope="col">fname</th>
                                    <th scope="col">lname</th>
                                    <th scope="col">status</th>
                                    <th scope="col">price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($allOrders as $order) : ?>
                                    <tr>
                                        <th scope="row">
                                            <?php echo $order->id; ?>
                                        </th>
                                        <td>
                                            <?php echo $order->username; ?>
                                        </td>
                                        <td>
                                            <?php echo $order->email; ?>
                                        </td>
                                        <td>
                                            <?php echo $order->fname; ?>
                                        </td>
                                        <td>
                                            <?php echo $order->lname; ?>
                                        </td>
                                        <td>
                                            completed
                                        </td>
                                        <td>
                                            <?php echo $order->price; ?>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>



</div>

<?php require "../includes/footer.php"; ?>