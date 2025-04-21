<?php
session_start();

include("connection.php");
include("function.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $con->real_escape_string($_POST['username']);
    $password = $con->real_escape_string($_POST['password']);
    $email = $con->real_escape_string($_POST['email']);
    //Check the email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format');</script>";
    } else {
        // Check the username 
        $check_query = "SELECT * FROM users WHERE username = '$username'";
        $check_result = $con->query($check_query);

        if ($check_result->num_rows > 0) {
            echo "<script>alert('Username already taken. Please choose another.');</script>";
        } else {
            // Insert new user
            $user_id = random_num(10);
            $query = "INSERT INTO users (user_id, username, password, email) VALUES ('$user_id','$username', '$password', '$email')";
            if ($con->query($query) === TRUE) {
                echo "<script>alert('Registration successful!');</script>";
                header("Location: login.php");
                exit;
            } else {
                echo "<script>alert('Error: " . $con->error . "');</script>";
            }
        }
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
            <li><a href="login.php">Login/Register</a></li>
          </ul>
        </nav>
        <a href="shoppingCart.php"
          ><img src="images/shoppingCart.jpg" width="30" height="30" alt="shoppingCart"
        /></a>
      </div>
    </div>

    <div class="account-page">
      <div class="container">
        <div class="row">
          
          <div class="col-2">
            <div class="form-container">
            <h2>Register</h2>
              <form id="RegForm" method="POST" action="">
                <input type="text" name="username" placeholder="Username" required />
                <input type="password" name="password" placeholder="Password" required />
                <input type="email" name="email" placeholder="Email" required />
                <button type="submit" name="register" class="btn">Register</button><br>
                <a href="login.php">Already have an account? Login here</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php include "footer.php"; ?>
  </body>
</html>
