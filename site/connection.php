<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "goods";

if(!$con = mysqli_connect($servername,$username,$password,$database))
{

	die("failed to connect!");
}