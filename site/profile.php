<?php
session_start();
include("function.php");
include("connection.php");
$user_data = check_login($con);
$user_id = $user_data['user_id'];

// Fetch user information
$query_user = "SELECT username, email FROM users WHERE user_id = '$user_id'";
$result_user = mysqli_query($con, $query_user);
$user_info = mysqli_fetch_assoc($result_user);

// Fetch products posted by the user
$query_products = "SELECT * FROM products WHERE user_id = '$user_id'";
$result_products = mysqli_query($con, $query_products);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile</title>
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
        <?php include "include/navbar.html"; ?>
    </div>
    <div class="profile">
      <div class="small-container">
        <div class="about">
          <h1>About</h1>
          <p><strong>Username:</strong> <?php echo htmlspecialchars($user_info['username']); ?></p>
          <p><strong>Email:</strong> <?php echo htmlspecialchars($user_info['email']); ?></p>
        </div>
      </div>
    
      <div class="small-container">
          <h1>Your Products</h1>
          <div class="row">
          <?php 
            if (mysqli_num_rows($result_products) > 0):           
                  while ($product = mysqli_fetch_assoc($result_products)) {
                      echo '<div class="col-4">';
                      echo '<a href="productDetails.php?product_id=' . $product['product_id'] . '">';
                      echo '<img src="' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '" />';
                      echo '<h4>' . htmlspecialchars($product['name']) . '</h4>';
                      echo '<p>$' . htmlspecialchars($product['price']) . '</p>';
                      echo '</a>';
                      echo '</div>';
                  }
            else:
              echo '<p>You have not posted any products.</p>';
            endif;
          ?>
          </div>
      </div>
    </div>
  </body>
</html>