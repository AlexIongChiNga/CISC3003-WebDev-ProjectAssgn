<?php
session_start();
include("connection.php");
include("function.php");

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = $_GET['search'];
    $search_query = $con->real_escape_string($search_query); // Sanitize user input

    // Query to search for the product by name
    $query = "SELECT * FROM products WHERE name LIKE '%$search_query%' LIMIT 1";
    $result = $con->query($query);

    if ($result && $result->num_rows > 0) {
        // If a product is found, redirect to the product details page
        $product = $result->fetch_assoc();
        header("Location: productDetails.php?product_id=" . $product['product_id']);
        exit;
    } else {
        // If no product is found, display a message
        echo "<script>alert('No such product found.');</script>";
        echo "<script>window.location.href='shop.php';</script>"; // Redirect back to the shop page
        exit;
    }
} else {
    // If the search query is empty, redirect back to the shop page
    echo "<script>alert('Please enter a search term.');</script>";
    echo "<script>window.location.href='shop.php';</script>";
    exit;
}
?>