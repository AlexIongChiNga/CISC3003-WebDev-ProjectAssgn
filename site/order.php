<?php
session_start();
include("function.php");
include("connection.php");
$user_data = check_login($con);
$user_id = $user_data['user_id'];

// Get all orders for the user
$order_query = $con->prepare("
    SELECT `order_id`, `price` as grand_total, `address`
    FROM `order`
    WHERE `user_id` = ?
    ORDER BY `order_id` DESC
");
$order_query->bind_param("i", $user_id);
$order_query->execute();
$order_result = $order_query->get_result();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Your Orders - Goods</title>
    <link rel="stylesheet" href="css/styles.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  </head>
  <body>
    <div class="container">
        <?php include "include/navbar.html"; ?>
    </div>

    <div class="small-container">
        <div class="orders-container">
            <div class="orders-header">
                <h2>Your Orders</h2>
            </div>

            <?php if ($order_result->num_rows > 0): ?>
                <?php while ($order = $order_result->fetch_assoc()): ?>
                    <div class="order-row">
                        <div class="order-info">
                            <span class="order-id">Order ID: #<?php echo $order['order_id']; ?></span>
                            <span class="order-grand-total">Grand Total: $<?php echo number_format($order['grand_total'], 2); ?></span>
                            <span class="order-address">Address: <?php echo $order['address']; ?></span>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="orders-header">
                    <p>No orders found. You haven't placed any orders yet.</p>
                    <a href="shop.php" class="btn order-back-btn">Browse Products</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include "include/footer.html"; ?>
  </body>
</html>