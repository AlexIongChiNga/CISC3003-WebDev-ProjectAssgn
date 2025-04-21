<?php
session_start();
include("function.php");
include("connection.php");
$user_data = check_login($con);

$featured_query = "SELECT product_id, price, name, rating, image, description FROM products LIMIT 8";
$featured_result = $con->query($featured_query);

$more_query = "SELECT product_id, price, name, rating, image, description FROM products LIMIT 12 OFFSET 8";
$more_result = $con->query($more_query);

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
    <div class="header">
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
        <div class="row">
          <div class="col-2">
            <h1>Buy and Sell<br />With Ease!</h1>
            <p>
                Discover unique items from trusted users. Whether you're buying or selling,<br />
                our platform makes it simple, secure, and convenient for everyone.
            </p>
            <a href="shop.php" class="btn">Explore Now &#8594;</a>
          </div>
        </div>
      </div>
    </div>

    <div class="small-container">
      <h2 class="title">Featured Products</h2>
      <div class="row">
        <?php
        if ($featured_result->num_rows > 0) {
          while ($product = $featured_result->fetch_assoc()) {
              echo '<div class="col-4">';
              echo '<a href="productDetails.php?product_id=' . $product['product_id'] . '">';
              echo '<img src="' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '" />';
              echo '<div class="rating">';
              for ($i = 0; $i < 5; $i++) {
                  if ($i < $product['rating']) {
                      echo '<i class="fa-solid fa-star"></i>';
                  } else {
                      echo '<i class="fa-regular fa-star"></i>';
                  }
              }
              echo '</div>';
              echo '<h4>' . htmlspecialchars($product['name']) . '</h4>';
              echo '<p>$' . htmlspecialchars($product['price']) . '</p>';
              echo '</a>';
              echo '</div>';
          }
      } else {
          echo '<p>No featured products available.</p>';
      }
        ?>
      </div>
    </div>

    <div class="small-container">
      <h2 class="title">More Products</h2>
      <div class="row">
        <?php
        if ($more_result->num_rows > 0) {
            while ($product = $more_result->fetch_assoc()) {
                echo '<div class="col-4">';
                echo '<a href="productDetails.php?id=' . $product['product_id'] . '">';
                echo '<img src="' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '" />';
                echo '<div class="rating">';
                for ($i = 0; $i < 5; $i++) {
                    if ($i < $product['rating']) {
                        echo '<i class="fa-solid fa-star"></i>';
                    } else {
                        echo '<i class="fa-regular fa-star"></i>';
                    }
                }
                echo '</div>';
                echo '<h4>' . htmlspecialchars($product['name']) . '</h4>';
                echo '<p>$' . htmlspecialchars($product['price']) . '</p>';
                echo '</a>';
                echo '</div>';
            }
        } else {
            echo '<p>No more products available.</p>';
        }
        ?>
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
  </body>
</html>