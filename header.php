<?php
/*
//Author:S M ABDULLAH FERDOUS
//Part of the CM4025 Enterprise web systems
//This page will be the header of the fornt end access system and
will be required most of the pages.
*/
//this will start session in every page where header is required
//if the user is logged in
	session_start();
	ini_set('display_errors', 1);
	error_reporting(~0);

 ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset = "utf-8">
		<meta name="description" content="This is a meta description">
		<meta name=viewport content="width=device-width,initial-scale=1">
		<link rel="stylesheet" href="style.css">
		<title>Welcome to RSS heaven</title>
	</head>
  <body class="body">

		<header>
				<?php
				//and show
				echo "<h1>Welcome to RSS Heaven</h1>";
				if (isset($_SESSION['userId'])) {
					//put user name to show who is log in
				  $userid= $_SESSION['userUid'];
					echo "<h3>You are logged in as User: $userid<h3>";
					//if user succesfully logged in the header will only show the logout button
					echo 	'	<form action="includes/logout.inc.php" method="post">
									<button type="submit" name="logout-submit">Logout</button>
									</form>';
				}
				else{
					//if the user is not logged in it will display folloing message
					echo "<h2>please sign in if you are already registered</h2>";
					//checking and creating error messages
					if(isset($_GET['error'])){
						if($_GET['error']=="wrongpassword"){
							echo '<span style="color:#FF0000;text-align:center;">Wrong Password!!please try again</span>';
						}
					if($_GET['error']=="nouser"){
							echo '<span style="color:#FF0000;text-align:center;">No user found!!please sign up</span>';
						}

					}
					//will show the login form for user to log in
					echo '
									<form action="includes/login.inc.php" method="post">
									<input type="text" name="mailuid" placeholder="Username/Email">
									<input type="password" name="pwd" placeholder="Password">
									<button type="submit" name="login-submit">Login</button>
									</form>
									'		;
					 echo '<h2>Please sign up here</h2>';
				   echo '<a href="signup.php" >Signup</a>';

				}

				 ?>

				<!-- login in form-->
		</header>
