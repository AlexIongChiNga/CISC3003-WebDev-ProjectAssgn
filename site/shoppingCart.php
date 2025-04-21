<?php
session_start();
include("function.php");
include("connection.php");
$user_data = check_login($con);
$user_id = $user_data['user_id'];

// Include product_id in the SELECT query
$query = "SELECT cart.cart_id, products.product_id, products.image, products.name, products.price, cart.quantity 
          FROM cart
          INNER JOIN products ON cart.product_id = products.product_id
          WHERE cart.user_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Goods</title>
    <link rel="stylesheet" href="css/styles.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    />
  </head>
  <body>
    <div class="container">
        <div class="navbar">
          <div class="logo">
            <img src="images/logo.png" width="125" alt="logo" />
          </div>
          <nav>
            <ul id="MenuItems">
              <li><a href="home.php">Home</a></li>
              <li><a href="shop.php">Shop</a></li>
              <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="postproduct.php">Post</a></li>
                <li><a href="logout.php">Logout</a></li>
              <?php else: ?>
                <li><a href="login.php">Login/Register</a></li>
              <?php endif; ?>
            </ul>
          </nav>
          <a href="shoppingCart.php"
          ><img src="images/shoppingCart.jpg" width="30" height="30" alt="shoppingCart"
        /></a>
        </div>
    </div>

    <div class="small-container cart-page">
      <table>
        <tr>
          <th>Product</th>
          <th>Quantity</th>
          <th>Subtotal</th>
        </tr>
        <?php
        $total = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $subtotal = $row['price'] * $row['quantity'];
                $total += $subtotal;
                echo '<tr>';
                echo '<td>';
                echo '<div class="cart-info">';
                echo '<img src="' . $row['image'] . '" alt="product" />';
                echo '<div>';
                echo '<p>' . $row['name'] . '</p>';
                echo '<a href="removeFromCart.php?id=' . $row['product_id'] . '">Remove</a>';
                echo '</div>';
                echo '</div>';
                echo '</td>';
                echo '<td><input type="number" value="' . $row['quantity'] . '" /></td>';
                echo '<td>$' . $subtotal . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="3">Your cart is empty.</td></tr>';
        }
        ?>
      </table>

      <div class="total-price">
        <table>
          <tr>
            <td>Subtotal</td>
            <td>$<?php echo $total; ?></td>
          </tr>
          <tr>
            <td>Tax</td>
            <td>$<?php echo number_format($total * 0.1, 2); ?></td>
          </tr>
          <tr>
            <td>Total</td>
            <td>$<?php echo number_format($total * 1.1, 2); ?></td>
          </tr>
        </table>
      </div>
    </div>

    <div class="footer">
      <div class="container">
        <div class="row">
          <div class="footer-col-1">
            <img src="images/logo.png" alt="logo" />
            <p>
              Our purpose is to connect people, enabling them to buy and sell goods securely and conveniently. 
              Discover unique items and create meaningful transactions within a trusted community.
            </p>
          </div>
          <div class="footer-col-2">
            <h3>Useful Links</h3>
            <ul>
              <li>Coupons</li>
              <li>Blog Post</li>
              <li>Return Policy</li>
              <li>Join Affiliate</li>
            </ul>
          </div>
          <div class="footer-col-3">
            <h3>Follow us</h3>
            <ul>
              <li>Facebook</li>
              <li>Twitter</li>
              <li>Instagram</li>
              <li>Youtube</li>
            </ul>
          </div>
        </div>
        <hr />
        <p class="copyright">Project</p>
      </div>
    </div>

    <script>
      var MenuItems = document.getElementById("MenuItems");

      MenuItems.style.maxHeight = "0px";

      function menutoogle() {
        if (MenuItems.style.maxHeight == "0px") {
          MenuItems.style.maxHeight = "200px";
        } else {
          MenuItems.style.maxHeight = "0px";
        }
      }
    </script>
  </body>
</html>