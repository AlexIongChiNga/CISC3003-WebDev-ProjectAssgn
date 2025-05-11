<?php
session_start();
include("connection.php");
include("function.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //something was posted
    $user_name = $_POST["username"];
    $password = $_POST["password"];

    if (empty($user_name) || empty($password) || is_numeric($user_name)) {
        die("<script>alert('Please enter valid username and password!'); window.history.back();</script>");
    }

    // Read from database
    $query = "SELECT * FROM users WHERE username = '$user_name' LIMIT 1";
    $result = mysqli_query($con, $query);

    if (!$result || mysqli_num_rows($result) != 1) {
        // wrong username
        die("<script>alert('Wrong username or password!'); window.history.back();</script>");
    }

    $user_data = mysqli_fetch_assoc($result);

    if (!$user_data["is_verified"]) {
        die("<script>alert('You are not verified yet, please check your email!'); window.history.back();</script>");
    }
    
    $hash = password_hash($user_data["password"], PASSWORD_DEFAULT);
    if (!password_verify($password, $hash)) {
        die("<script>alert('Wrong username or password!'); window.history.back();</script>");
    }

    $_SESSION["user_id"] = $user_data["user_id"];
    header("Location: home.php");
    die();
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
            <?php include "include/navbar.html"; ?>
    </div>

    <?php
    //error message
    if (isset($_GET['error'])) {
        $error = $_GET['error'];
        if ($error == 'not_logged_in') {
            echo '<div class="error-message">You must be logged in to access this page.</div>';
        }
    }
    ?>

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
                <a href="forgetPassword.php">Forgot Password</a><br>
                <a href="register.php">Don't have an account? Register here</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php include "include/footer.html"; ?>
  </body>
</html>
