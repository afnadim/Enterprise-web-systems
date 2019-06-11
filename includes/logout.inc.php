<?php
/*
//Author:S M ABDULLAH FERDOUS
//Part of the CM4025 Enterprise web systems
//This file will deal with whenever user log out from the system
*/
session_start();
header("Location: ../index.php");
//getting the current timestamp of logout
$currenttime=time();
$username = $_SESSION['userUid'];
$host = "localhost";
$user = "root";
$pass = "";
$database = "loginsystem";

$connection  = mysqli_connect($host, $user, $pass, $database)
  or die ("Error is " . $mysqli_error ($connection));

$username = $connection->real_escape_string ($username);
$currentTime= $connection->real_escape_string ($currenttime);
//updaeing lastLogOutTime in the databse
$query="UPDATE users SET lastLogOutTime='$currentTime' WHERE userName='$username'";
$results = $connection->query ($query);
echo $connection->error;
//destroying the users session
session_unset();
session_destroy();
