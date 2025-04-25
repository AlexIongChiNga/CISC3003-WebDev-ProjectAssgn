<?php
session_start();
include("function.php");
include("connection.php");

// Check if the user is logged in and get user data
$user_data = check_login($con);

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Validate the product ID
if ($product_id <= 0) {
    die("Invalid product ID.");
}

$user_id = $user_data['user_id']; // Get the logged-in user's ID

// Check if the product is already in the cart
$query = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // If the product is already in the cart, update the quantity
    $update_query = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?";
    $update_stmt = $con->prepare($update_query);
    $update_stmt->bind_param("ii", $user_id, $product_id);
    $update_stmt->execute();
} else {
    // If the product is not in the cart, insert it
    $insert_query = "INSERT INTO cart (cart_id, user_id, product_id, quantity) VALUES (0, ?, ?, 1)";
    $insert_stmt = $con->prepare($insert_query);
    $insert_stmt->bind_param("ii", $user_id, $product_id);
    $insert_stmt->execute();
}

// Redirect to the shopping cart page
header("Location: shoppingCart.php");
exit;
?>
