<?php
session_start();
include "connection.php";
include "function.php";


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['forget'])) {
    require "sendMail.php";
    //something was posted
    $user_name = $_POST["username"];

    if (empty($user_name) || is_numeric($user_name)) {
        die("<script>alert('Please enter valid username!'); window.history.back();</script>");
    }

    // Read from database
    $query = "SELECT * FROM users WHERE username = '$user_name' LIMIT 1";
    $result = mysqli_query($con, $query);

    if (!$result || mysqli_num_rows($result) != 1) {
        // wrong username
        die("<script>alert('Username not found!'); window.history.back();</script>");
    }

    $user_data = mysqli_fetch_assoc($result);
    $user_id = $user_data["user_id"];
    $email = $user_data["email"];

    $mail = new Mail();
    $mail->sendForgetPasswordEmail($email, $user_id);
    echo "<script>
      alert('We received a request to reset your password! Please check your email!');
      window.location.href = 'login.php';
    </script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset'])) {
    //something was posted
    $password = $_POST["password"];
    $user_id = intval($_GET["id"]);
    // Update from database
    $query = "UPDATE users SET password = ? WHERE user_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("si", $password, $user_id);
    $stmt->execute();

    echo "<script>
      alert('Your password is reset!');
      window.location.href = 'login.php';
    </script>";
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forget Password</title>
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

    <div class="account-page">
      <div class="container">
        <div class="row">
          <div class="col-2">
            <div class="form-container">
              <h2>Forget Passowrd</h2>

              <?php if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
                  $user_id = intval($_GET["id"]); // Convert to integer for safety

                  // Query database to check if the user exists
                  $query = "SELECT * FROM users WHERE user_id = $user_id LIMIT 1";
                  $result = mysqli_query($con, $query);

                  if ($result && mysqli_num_rows($result) > 0) {
                      $user_data = mysqli_fetch_assoc($result);
                      ?>
                      <form id="ForgetPassword" method="POST" action="">
                            <input type="password" name="password" placeholder="Enter new password" required />
                            <button type="submit" name="reset" class="btn">Reset Password</button>
                      </form>

                      <?php
                  } else {
                      die("<script>alert('Invalid user'); window.history.back();</script>");
                  }
              } else {
                   ?>

            <form id="ForgetPassword" method="POST" action="">
              <input type="text" name="username" placeholder="Username" required />
              <button type="submit" name="forget" class="btn">Reset Credentials</button>
            </form>
            <?php
              } ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php include "include/footer.html"; ?>
  </body>
</html>
