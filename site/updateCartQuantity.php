<?php
session_start();
include("function.php");
include("connection.php");

// Check if the user is logged in
$user_data = check_login($con);
$user_id = $user_data['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = isset($_POST['productId']) ? (int)$_POST['productId'] : 0;
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    // Validate inputs
    if ($product_id > 0 && $quantity > 0) {
        $query = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("iii", $quantity, $user_id, $product_id);
        $stmt->execute();

        echo "Quantity updated successfully!";
    } else {
        echo "Invalid product ID or quantity!";
    }
} else {
    echo "Invalid request method!";
}
?>