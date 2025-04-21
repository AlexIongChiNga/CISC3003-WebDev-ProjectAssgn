<?php
session_start();
include("connection.php");
include("function.php");

if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$user_name = $_POST['username'];
		$password = $_POST['password'];

		if(!empty($user_name) && !empty($password) && !is_numeric($user_name))
		{
			//read from database
			$query = "select * from users where username = '$user_name' limit 1";
			$result = mysqli_query($con, $query);

			if($result)
			{
				if($result && mysqli_num_rows($result) > 0)
				{
					$user_data = mysqli_fetch_assoc($result);
					
					if($user_data['password'] === $password)
					{
						$_SESSION['user_id'] = $user_data['user_id'];
						header("Location: home.php");
						die;
					} else {
            echo "<script>alert('Wrong username or password!');</script>";
          }
				}
			}
			
			echo "<script>alert('Wrong username or password!');</script>";
		}else
		{
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

    <?php include "footer.php"; ?>
  </body>
</html>