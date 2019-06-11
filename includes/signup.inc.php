<?php
/*
//Author:S M ABDULLAH FERDOUS
//Part of the CM4025 Enterprise web systems
//This file will deal with the signup process once user click on the signup button
*/
//makeing sure user click on the signup button before get to this page
if (isset($_POST['signup-submit'])) {
  //Database setup file
  require 'dbh.inc.php';
//getting the details from the input boxes
  $username = $_POST['uid'];
  $email = $_POST['mail'];
  $password = $_POST['pwd'];
  $passwordRepeat = $_POST['pwd-repeat'];
//check if any registration field is left empthy
  if (empty($username)|| empty($email)|| empty($password)|| empty($passwordRepeat)) {
    header("Location: ../signup.php?error=empthyfields&uid=".$username."&mail=".$email);
    //no code to run after this point if user makes a mistake
    exit();
  }
//check for valid email and username
  else if(!filter_var($email,FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/",$username)){
    header("Location: ../signup.php?error=invalidmail&uid");
    exit();
  }

//check for valid email
  else if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
    header("Location: ../signup.php?error=invalidmail&uid=".$username);
    exit();
  }

  //check for valid username
    else if (!preg_match("/^[a-zA-Z0-9]*$/",$username)){
      header("Location: ../signup.php?error=invaliduid&mail=".$email);
      exit();
    }
//cheking if the both password input field have the same value
  else if($password !== $passwordRepeat){
    header("Location: ../signup.php?error=passwordcheck&mail=".$username."&mail=".$email);
    exit();
  }
  //if the usrname already taken
  else{
    $sql="SELECT userName FROM users WHERE userName=?";
    $stmt=mysqli_stmt_init($connection);
    if(!mysqli_stmt_prepare($stmt, $sql)){
      header("Location: ../signup.php?error=sqlerror");
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "s", $username);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $resultCheck = mysqli_stmt_num_rows($stmt);
      if($resultCheck >0 ) {
        header("Location: ../signup.php?error=usertaken&mail=".$username);
        exit();
      }
      else{
      //if all the cheacks are passed the details will be inserted into the database and user will be created
        $sql="INSERT INTO users (userName,userEmail,pwdUsers) VALUES (? , ?, ?) ";
        $stmt=mysqli_stmt_init($connection);
        if(!mysqli_stmt_prepare($stmt, $sql)){
          header("Location: ../signup.php?error=sqlerror");
          exit();
          }
          else{
            //hashing the password
            $hashedpwd = password_hash($password, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedpwd);
            mysqli_stmt_execute($stmt);
            header("Location: ../index.php?signup=success");
            exit();
          }
      }
    }
  }
  //closeing statements and connections
  mysqli_stmt_close($stmt);
  mysqli_close($connection);
}
//sending the user back to signup page incase user trying to access this page without clicking the signup button.
//it is porbably impossible to do that but better stay safe
else{
  header("Location: ../signup.php");
  exit();
}
