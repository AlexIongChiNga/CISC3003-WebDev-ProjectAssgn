<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "goods";

// Create a connection
$con = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>