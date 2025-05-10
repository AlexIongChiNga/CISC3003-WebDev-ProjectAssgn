<?php
session_start();

include("function.php");
include("connection.php");
$user_data = check_login($con);
$user_id = $user_data['user_id'];

// Create images directory if it doesn't exist
if (!file_exists('images')) {
    mkdir('images', 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Validate inputs
    if (empty($name) || empty($price) || empty($description)) {
        die("<script>alert('Please fill in all fields.'); window.history.back();</script>");
    }

    // Check if image was uploaded
    if (empty($_FILES["image"]["tmp_name"])) {
        die("<script>alert('Please select an image file.'); window.history.back();</script>");
    }

    // Check if the file is an actual image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        die("<script>alert('File is not an image.'); window.history.back();</script>");
    }

    // Get image info
    $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    // Check file type
    if (!in_array($imageFileType, $allowedExtensions)) {
        die("<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.'); window.history.back();</script>");
    }

    // Check file size (max 5MB)
    if ($_FILES["image"]["size"] > 5000000) {
        die("<script>alert('Sorry, your file is too large (max 5MB).'); window.history.back();</script>");
    }

    try {
        // Get the maximum existing product_id
        $query = "SELECT MAX(product_id) as max_id FROM products";
        $result = $con->query($query);
        $row = $result->fetch_assoc();
        $new_product_id = $row['max_id'] + 1;

        // If no products exist yet, start with 1
        if ($new_product_id === null) {
            $new_product_id = 1;
        }

        // Generate filename with the new product_id
        $targetFile = "images/product" . $new_product_id . "." . $imageFileType;

        // Move uploaded file
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            throw new Exception("Failed to move uploaded file.");
        }

        // Insert product into database with the new product_id
        $query = "INSERT INTO products (product_id, user_id, name, image, price, description) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param("iissds", $new_product_id, $user_id, $name, $targetFile, $price, $description);

        if ($stmt->execute()) {
            echo "<script>alert('Product added successfully'); window.location.href = 'postproduct.php';</script>";
        } else {
            // Delete the uploaded image if DB insert failed
            if (file_exists($targetFile)) {
                unlink($targetFile);
            }
            throw new Exception("Database insert failed.");
        }
    } catch (Exception $e) {
        die("<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.history.back();</script>");
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
            <input type="file" name="image" class="box">
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
