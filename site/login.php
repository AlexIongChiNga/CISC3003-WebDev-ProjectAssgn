<?php
session_start();
include("connection.php"); // Ensure this file defines $con
include("function.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Something was posted
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password) && !is_numeric($username)) {
        // Read from database using prepared statements
        $query = "SELECT * FROM users WHERE username = ? LIMIT 1";
        $stmt = $con->prepare($query); // Ensure $con is properly defined in connection.php
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user_data = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user_data['password'])) {
                $_SESSION['user_id'] = $user_data['user_id'];
                header("Location: home.php");
                die;
            } else {
                echo "<script>alert('Wrong username or password!');</script>";
            }
        } else {
            echo "<script>alert('Wrong username or password!');</script>";
        }
    } else {
        echo "<script>alert('Please enter valid username and password!');</script>";
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
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
              <h2>Login</h2>
              <form id="LoginForm" method="POST" action="">
                <input type="text" name="username" placeholder="Username" required />
                <input type="password" name="password" placeholder="Password" required />
                <button type="submit" name="login" class="btn">Login</button>
                <a href="">Forgot Password</a><br>
                <a href="register.php">Don't have an account? Register here</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="footer">
      <div class="container">
        <div class="row">
          <div class="footer-col-1">
            <img src="images/logo.png" alt="logo" />
            <p>
              Our purpose is to connect people, enabling them to buy and sell goods securely and conveniently. 
              Discover unique items and create meaningful transactions within a trusted community.
            </p>
          </div>
          <div class="footer-col-2">
            <h3>Useful Links</h3>
            <ul>
              <li>Coupons</li>
              <li>Blog Post</li>
              <li>Return Policy</li>
              <li>Join Affiliate</li>
            </ul>
          </div>
          <div class="footer-col-3">
            <h3>Follow us</h3>
            <ul>
              <li>Facebook</li>
              <li>Twitter</li>
              <li>Instagram</li>
              <li>Youtube</li>
            </ul>
          </div>
        </div>
        <hr />
        <p class="copyright">Project</p>
      </div>
    </div>
  </body>
</html>