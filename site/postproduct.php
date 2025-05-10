<?php
session_start();

include("function.php");
include("connection.php");
$user_data = check_login($con);
$user_id = $user_data['user_id'];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];


    // Check if the file is an actual image
    if (empty($_FILES["image"]["name"]) || !getimagesize($_FILES["image"]["tmp_name"])) {
        die("File is not an image.");
    }

    // Validate inputs
    if (!empty($name) && !empty($price) && !empty($description)) {
        // Get the next product ID for naming images
        $query = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'products' AND table_schema = 'goods'";
        $result = $con->query($query);
        $row = $result->fetch_assoc();
        $nextProductId = $row['AUTO_INCREMENT'];

        $targetFile = __DIR__ . "images/" . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Assign new image name based on product ID
        $targetFile = "images/product" . $nextProductId . "." . $imageFileType;

        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);

        // Insert product into the database
        $query = "INSERT INTO products (user_id, name, image, price, description) VALUES (?, ?, ?, ?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param("issds", $user_id, $name, $targetFile, $price, $description);


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
        <?php include "include/navbar.html"; ?>
    </div>

    <div class="post-form">
        <div class="small-container">
        <h2>Post your Product</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" placeholder="enter product name" class="box" required />
            <label for="image">Image:</label>
            <input type="file" name="image" required accept="image/*" class="box">
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" placeholder="enter product price" class="box" required />
            <label for="description">Description:</label><br>
            <textarea class="description" name="description" placeholder="enter product description" rows="5" class="box" required></textarea>
            <button type="submit" class="btn">Post Product</button>
        </form>
        </div>
    </div>

    <?php include "include/footer.html"; ?>
  </body>
</html>
