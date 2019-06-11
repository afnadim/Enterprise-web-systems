<?php
/*
//Author:S M ABDULLAH FERDOUS
//Part of the CM4025 Enterprise web systems
//This file is the index page.this file will chaeck if the user is log in or logout
and act accordingly
*/
//getting the header file
require "header.php";
include_once 'includes/dbh.inc.php';
?>
		<main>
			<?php
			//checking if the user is logged in
				if (isset($_SESSION['userId'])) {
				  //if the user is logged in forward the user to homepage
					header("Location: ../homepage.php");
				}
				else{
					//display if no user is lossged in
					echo "<h1>No user is logged in <h1>"	;
				}
			?>

		</main>
	<?php
	require "footer.php";
	?>
