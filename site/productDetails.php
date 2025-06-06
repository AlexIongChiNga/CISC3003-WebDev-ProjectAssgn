<?php
session_start();
include("function.php");
include("connection.php");
$user_data = check_login($con);

$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
$query = "SELECT * FROM products WHERE id = $product_id";
$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
$query = "SELECT * FROM products WHERE product_id = $product_id";
$result = $con->query($query);

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    die("Product not found.");
}
$result = $con->query($query);

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
        <?php include "include/navbar.html"; ?>
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
        </div>
        <div class =row-2>
          <h3>
            Product Details
            <i class="fa-solid fa-indent"></i>
          </h3>
          <br>
          <p><?php echo htmlspecialchars($product['description']); ?></p>
        </div>
      </div>
    </div>

    <?php include "include/footer.html"; ?>
  </body>
</html>
