<?php

session_start();
// pop confirm logout, if confirm, proceed logout
echo '<script>
    if(confirm("Are you sure you want to logout?")){
        window.location.href = "logout.php";
    }
</script>';

if(isset($_SESSION['user_id'])){
    unset($_SESSION['user_id']);
}

header("Location: login.php");
die;
