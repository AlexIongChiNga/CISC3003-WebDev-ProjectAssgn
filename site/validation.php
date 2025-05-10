<?php
$id = $_GET['id'];

// Prepare the query to check if the user exists
$query = $con->prepare("SELECT COUNT(*) FROM users WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$query->bind_result($count);
$query->fetch();

if ($count > 0) {
    echo "ok";
} else {
    echo "User not found";
}
