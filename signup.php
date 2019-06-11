<?php
/*
//Author:S M ABDULLAH FERDOUS
//Part of the CM4025 Enterprise web systems
//This page will help the user to sign up to the service.
*/
//getting the header file
require "header.php";
?>

		<main>
      <h2>Fill in the details below to Signup</h2>

			<?php
			//generateing error messages for sign up forms
			if(isset($_GET['error'])){
					if($_GET['error']=="empthyfields"){
						echo '<span style="color:#FF0000;text-align:center;">Please fill all the fields</span>';
					}
		      else if ($_GET['error']=="passwordcheck") {
				  	echo '<span style="color:#FF0000;text-align:center;">Passwords does not match</span>';
		    	}
			  	else if ($_GET['error']=="usertaken") {
						 echo '<span style="color:#FF0000;text-align:center;">Usernaname already Taken</span>';
					 }

			}
			//action if signup is successfull
			else if(isset($_GET['signup'])){
				if ($_GET['signup']== 'success') {
					//once sign up is successfull user get directed to the index page where they can sign in
					header("Location: ../index.php");
				}
			}

			 ?>
			 <!--generateing signup form-->
      <form action="includes/signup.inc.php" method="post">
        <input type="text" name="uid" placeholder="Username">
        <input type="text" name="mail" placeholder="E-mail">
        <input type="password" name="pwd" placeholder="Password">
        <input type="password" name="pwd-repeat" placeholder="repeat-Password">
        <button type="submit" name="signup-submit">Signup</button>

		</main>

	<?php
	require "footer.php";
	?>
