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

    <?php include "footer.html"; ?>
  </body>
</html>