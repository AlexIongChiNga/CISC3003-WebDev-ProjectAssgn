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
    <script>
      // JavaScript function to handle quantity change
      function updateCart(productId, price) {
        const quantityInput = document.getElementById(`quantity-${productId}`);
        const quantity = parseInt(quantityInput.value) || 1;

        // Update Subtotal for the product
        const subtotalElement = document.getElementById(`subtotal-${productId}`);
        const subtotal = price * quantity;
        subtotalElement.textContent = `$${subtotal.toFixed(2)}`;

        // Update Total, Tax, and Grand Total
        let total = 0;
        const subtotals = document.querySelectorAll('.subtotal');
        subtotals.forEach((el) => {
          total += parseFloat(el.textContent.replace('$', ''));
        });

        const tax = total * 0.1;
        const grandTotal = total + tax;

        document.getElementById('cart-total').textContent = `$${total.toFixed(2)}`;
        document.getElementById('cart-tax').textContent = `$${tax.toFixed(2)}`;
        document.getElementById('cart-grand-total').textContent = `$${grandTotal.toFixed(2)}`;

        // Send updated quantity to the server
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "updateCartQuantity.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText); // Optional: Log server response
          }
        };
        xhr.send(`productId=${productId}&quantity=${quantity}`);
      }
    </script>
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
              <li><a href="postproduct.php">Post</a></li>
              <li><a href="logout.php">Logout</a></li>
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
                echo '<td><input type="number" id="quantity-' . $row['product_id'] . '" value="' . $row['quantity'] . '" min="1" onchange="updateCart(' . $row['product_id'] . ', ' . $row['price'] . ')" /></td>';
                echo '<td class="subtotal" id="subtotal-' . $row['product_id'] . '">$' . $subtotal . '</td>';
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
            <td id="cart-total">$<?php echo $total; ?></td>
          </tr>
          <tr>
            <td>Tax</td>
            <td id="cart-tax">$<?php echo number_format($total * 0.1, 2); ?></td>
          </tr>
          <tr>
            <td style="background-color: #ff523b; color: white;">Grand Total</td>
            <td style="background-color: #ff523b; color: white;"
                id="cart-grand-total">
                $<?php echo number_format($total * 1.1, 2); ?></td>
          </tr>
        </table>
      </div>
    </div>

    <?php include "include/footer.html"; ?>

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
