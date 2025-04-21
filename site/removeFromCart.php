<?php
session_start();
include("function.php");
include("connection.php");

$user_data = check_login($con);
$user_id = $user_data['user_id'];

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($product_id <= 0) {
    die("Invalid product ID.");
}

// Remove the product from the cart for the logged-in user
$query = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("ii", $user_id, $product_id);

if ($stmt->execute()) {
    header("Location: shoppingCart.php");
    exit;
} else {
    echo "Failed to remove the product from the cart.";
}
?>