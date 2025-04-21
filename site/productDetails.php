<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "goods";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
$query = "SELECT * FROM products WHERE id = $product_id";
$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
$query = "SELECT * FROM products WHERE product_id = $product_id"; 
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    die("Product not found.");
}
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    die("Product not found.");
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($product['name']); ?></title>
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
          <a href="shoppingCart.php"
          ><img src="images/shoppingCart.jpg" width="30" height="30" alt="shoppingCart"
        /></a>
        </div>
    </div>
    
    <div class="small-container single-product">
      <div class="row">
        <div class="col-2">
          <img
            src="<?php echo htmlspecialchars($product['image']); ?>"
            style="width: 100%"
            id="ProductImg"
            alt="<?php echo htmlspecialchars($product['name']); ?>"
          />
        </div>
        <div class="col-2">
          <h1><?php echo htmlspecialchars($product['name']); ?></h1>
          <h4>$<?php echo htmlspecialchars($product['price']); ?></h4>
          <input type="number" value="1" />
          <a href="addToCart.php?id=<?php echo $product['product_id']; ?>" class="btn">Add to Cart</a>
          <h3>
            Product Details
            <i class="fa-solid fa-indent"></i>
          </h3>
          <br />
          <p><?php echo htmlspecialchars($product['description']); ?></p>
        </div>
      </div>
    </div>
    <!--<div class="small-container">
      <div class="row row-2">
        <h2>Related Products</h2>
        <p>View More</p>
      </div>
    </div>
    <div class="small-container">
      <div class="row">
        <?php
        /*$related_query = "SELECT * FROM products WHERE category = '" . $conn->real_escape_string($product['category']) . "' AND id != $product_id LIMIT 4";
        $related_result = $conn->query($related_query);

        if ($related_result->num_rows > 0) {
            while ($related = $related_result->fetch_assoc()) {
                echo '<div class="col-4">';
                echo '<img src="' . htmlspecialchars($related['image']) . '" alt="' . htmlspecialchars($related['name']) . '" />';
                echo '<div class="rating">';
                for ($i = 0; $i < 5; $i++) {
                    if ($i < $related['rating']) {
                        echo '<i class="fa-solid fa-star"></i>';
                    } else {
                        echo '<i class="fa-regular fa-star"></i>';
                    }
                }
                echo '</div>';
                echo '<h4>' . htmlspecialchars($related['name']) . '</h4>';
                echo '<p>$' . htmlspecialchars($related['price']) . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>No related products available.</p>';
        }*/
        ?>
      </div>
    </div>-->

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
      var ProductImg = document.getElementById("ProductImg");
      var SmallImg = document.getElementsByClassName("small-img");

      for (let i = 0; i < SmallImg.length; i++) {
        SmallImg[i].onclick = function () {
          ProductImg.src = SmallImg[i].src;
        };
      }
    </script>
  </body>
</html>