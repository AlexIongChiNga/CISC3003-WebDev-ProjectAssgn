<?php
session_start();
include("function.php");
include("connection.php");
$user_data = check_login($con);
$user_id = $user_data['user_id'];

// Get cart items to calculate total
$query = "SELECT SUM(products.price * cart.quantity) as total
          FROM cart
          INNER JOIN products ON cart.product_id = products.product_id
          WHERE cart.user_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total = $row['total'] ?? 0;
$tax = $total * 0.1;
$grandTotal = $total + $tax;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['payment'])) {
    // Get the submitted address
    $address = $_POST["address"];

    // Start a transaction
    $con->begin_transaction();

    try {
        // 1. Insert into the `order` table
        $query = "INSERT INTO `order` (address, user_id, price) VALUES (?, ?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param("sii", $address, $user_id, $grandTotal);
        $stmt->execute();
        $order_id = $con->insert_id; // Get the last inserted order ID

        // 2. Insert all cart data into the `order_detail` table
        $query = "INSERT INTO order_detail (product_id, user_id, quantity)
                  SELECT cart.product_id, cart.user_id, cart.quantity
                  FROM cart
                  WHERE cart.user_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        // 3. Delete all cart data for the current user
        $query = "DELETE FROM cart WHERE user_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        // Commit the transaction
        $con->commit();

        echo "<script>
            alert('Payment successful! Your order has been placed.');
            window.location.href = 'order.php';
        </script>";

    } catch (Exception $e) {
        // Rollback the transaction if any query fails
        $con->rollback();
        echo "<script>
            alert('An error occurred while processing your payment. Please try again.');
            window.location.href = 'payment.php';
        </script>";
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Payment - Goods</title>
    <link rel="stylesheet" href="css/styles.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  </head>
  <body>
    <div class="container">
        <?php include "include/navbar.html"; ?>
    </div>

    <div class="small-container cart-page">
        <h2 class="title">Payment Information</h2>
        
        <div class="payment-container">
            <div class="payment-summary">
                <h3>Order Summary</h3>
                <table>
                    <tr>
                        <td>Subtotal</td>
                        <td>$<?php echo number_format($total, 2); ?></td>
                    </tr>
                    <tr>
                        <td>Tax (10%)</td>
                        <td>$<?php echo number_format($tax, 2); ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Grand Total</td>
                        <td style="font-weight: bold;">$<?php echo number_format($grandTotal, 2); ?></td>
                    </tr>
                </table>
            </div>

            <form class="payment-form" method="POST" action="">
                <h3>Payment Details</h3>
                
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" required>
                </div>

                <div class="form-group">
                    <label for="card-name">Name on Card</label>
                    <input type="text" id="card-name" name="card-name" required>
                </div>
                
                <div class="form-group">
                    <label for="card-number">Card Number</label>
                    <input type="text" id="card-number" name="card-number" placeholder="1234 5678 9012 3456" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="expiry">Expiry Date</label>
                        <input type="text" id="expiry" name="expiry" placeholder="MM/YY" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="cvv">CVV</label>
                        <input type="text" id="cvv" name="cvv" placeholder="123" required>
                    </div>
                </div>
                
                <button type="submit" name="payment" class="btn">Complete Payment</button>
            </form>
        </div>
    </div>

    <?php include "include/footer.html"; ?>

    <script>
        // Basic card number formatting
        document.getElementById('card-number').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^\d]/g, '').replace(/(.{4})/g, '$1 ').trim();
        });

        // Expiry date formatting
        document.getElementById('expiry').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^\d]/g, '').replace(/(\d{2})(\d)/, '$1/$2').trim();
        });
    </script>
  </body>
</html>