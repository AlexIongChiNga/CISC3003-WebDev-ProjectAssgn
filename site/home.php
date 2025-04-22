<?php

session_start();
include("function.php");
include("connection.php");
$user_data = check_login($con);

$featured_query = "SELECT product_id, price, name, rating, image, description FROM products LIMIT 8";
$featured_result = $con->query($featured_query);

$more_query = "SELECT product_id, price, name, rating, image, description FROM products LIMIT 8 OFFSET 8";
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
            <?php include "include/navbar.html"; ?>
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
              echo '<a href="productDetails.php?product_id=' . $product['product_id'] . '">'; // Add link to productDetails.php
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
              echo '</a>'; // Close the link
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
            echo '<p>No more products available.</p>';
        }
        ?>
      </div>
    </div>

    <?php include "include/footer.html"; ?>
  </body>
</html>
