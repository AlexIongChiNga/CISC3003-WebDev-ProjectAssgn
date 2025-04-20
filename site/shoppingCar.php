<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "goods";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT car.id, products.image, products.name, products.price, car.quantity 
          FROM car 
          INNER JOIN products ON car.product_id = products.id";
$result = $conn->query($query);

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
              <li><a href="login.php">Login/Register</a></li>
            </ul>
          </nav>
          <a href="shoppingCar.php"
          ><img src="images/shoppingCar.jpg" width="30" height="30" alt="shoppingCar"
        /></a>
        </div>
    </div>

    <div class="small-container car-page">
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
                echo '<div class="car-info">';
                echo '<img src="' . $row['image'] . '" alt="product" />';
                echo '<div>';
                echo '<p>' . $row['name'] . '</p>';
                echo '<small>Price: $' . $row['price'] . '</small>';
                echo '<br />';
                echo '<a href="removeFromCar.php?id=' . $row['id'] . '">Remove</a>';
                echo '</div>';
                echo '</div>';
                echo '</td>';
                echo '<td><input type="number" value="' . $row['quantity'] . '" /></td>';
                echo '<td>$' . $subtotal . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="3">Your car is empty.</td></tr>';
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