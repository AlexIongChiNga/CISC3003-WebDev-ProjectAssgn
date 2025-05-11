<?php
include("function.php");
include("connection.php");
$id = $_GET['id'] ?? 0; // Ensure ID is set

// Prepare the query to check if the user exists
$query = $con->prepare("SELECT COUNT(*) FROM users WHERE user_id = ?");
$query->bind_param("i", $id);
$query->execute();
$query->store_result(); // Store the result for count retrieval
$query->bind_result($count);
$query->fetch();

if ($count == 0) {
    echo "User not found";
} else {
    $updateQuery = $con->prepare("UPDATE users SET is_verified = 1 WHERE user_id = ?");
    $updateQuery->bind_param("i", $id);
    if ($updateQuery->execute()) {
        echo "<scipt>alert('Verification Completed! Welcome!');</scipt>";
        $_SESSION["user_id"] = $id;
        header("Location: home.php");
        die();
    } else {
        echo "Failed to update user verification.";
    }
}
?>
