<?php
/*
//Author:S M ABDULLAH FERDOUS
//Part of the CM4025 Enterprise web systems
//This file will deal with the users login process
*/
include_once 'includes/dbh.inc.php';
//check if the login button is clicked or not
if (isset($_POST['login-submit'])) {
  require 'dbh.inc.php';
  //getting the values from the input fields
  $mailuid = $_POST['mailuid'];
  $password = $_POST['pwd'];
  //check if any login field is left empty
  if (empty($mailuid)|| empty($password)) {
    header("Location: ../index.php?error=emptyfields");
    exit();
  }
  //if none of the fields are empty check the database for the user
  else{
    $sql="SELECT * FROM users WHERE userName=?;";
    $stmt=mysqli_stmt_init($connection);
    //report and conncetion error
    if (!mysqli_stmt_prepare($stmt,$sql)) {
      header("Location: ../index.php?error=sqlerror");
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt,"s",$mailuid);
      mysqli_stmt_execute($stmt);
      $result=mysqli_stmt_get_result($stmt);

      //if user found we will check the password
      if ($row= mysqli_fetch_assoc($result)) {
        $pwdCheck = password_verify($password, $row['pwdUsers']);
        //if password is wrong send the user back to he main page
        //show them error message in the main page
        if($pwdCheck == false){
        header("Location: ../index.php?error=wrongpassword");
        exit();
        }
        else if($pwdCheck == true){
          //if password checks is right we will start a session with the user
          session_start();
          $_SESSION['userId'] = $row['userEmail'];
          $_SESSION['userUid'] = $row['userName'];
          $_SESSION['lastlogout'] = $row['lastLogOutTime'];
          /*
          //take the user back to index page.Index page will check the session and
          display the homepage of the user
          */
          header("Location: ../index.php?login=success");
          exit();

        }
        else{
        //wrong password error message
        header("Location: ../index.php?error=wrongpassword");
        exit();

        }
      }
      //if user not found show error
      else{
      header("Location: ../index.php?error=nouser");
      exit();

      }

    }

  }


}
else{
  header("Location: ../index.php");
  exit();

}
