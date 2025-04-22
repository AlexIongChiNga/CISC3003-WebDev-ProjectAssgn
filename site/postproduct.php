<?php
session_start();

include("function.php");
include("connection.php");
$user_data = check_login($con);
$user_id = $user_data['user_id'];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $image = $_POST['image'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Validate inputs
    if (!empty($name) && !empty($image) && !empty($price) && !empty($description)) {
        // Insert product into the database
        $query = "INSERT INTO products (user_id, name, image, price, description) VALUES (?, ?, ?, ?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param("issds", $user_id, $name, $image, $price, $description);

        if ($stmt->execute()) {
            echo "<script>alert('Product added successfully!');</script>";
        } else {
            echo "<script>alert('Failed to add product.');</script>";
        }
    } else {
        echo "<script>alert('Please fill in all fields.');</script>";
    }
}
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
    </div>

    <div class="post-form">
        <div class="small-container">
        <h2>Post your Product</h2>
        <form method="POST" action="">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" required />
            <label for="image">Image URL:</label>
            <input type="text" id="image" name="image" required />
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required />
            <label for="description">Description:</label><br>
            <textarea class="description" name="description" rows="5" required></textarea>
            <button type="submit" class="btn">Post Product</button>
        </form>
        </div>
    </div>

    <?php include "include/footer.html"; ?>
  </body>
</html>
