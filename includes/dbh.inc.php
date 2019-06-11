<!--
//Author:S M ABDULLAH FERDOUS
//Part of the CM4025 Enterprise web systems
//This is the database set up file.the tables will automaticall generated if
does not exis already
-->
<html>
  <head>
    <title>RSS Heaven</title>
  </head>

  <body>
    <?php
  	ini_set('display_errors', 1);
	  error_reporting(~0);
    $host = "localhost";
    $user = "root";
    $pass = "";
    $database = "loginsystem";
    $connection  = mysqli_connect($host, $user, $pass, $database)
      or die ("Error is " . $mysqli_error ($connection));
    //creating users table
    $query1 = "CREATE TABLE IF NOT EXISTS users ( userName varchar (15) PRIMARY KEY,userEmail varchar (15),pwdUsers varchar (512),lastLogOutTime INT(11))";
    //creating rssFeeds table
    $query2 = "CREATE TABLE IF NOT EXISTS rssFeeds (id INT(11),userName varchar (15),rssLink varchar(512),rssTitle varchar(512))";

    $ret = $connection->query ($query1);
    $ret = $connection->query ($query2);
    echo $connection->error;
    ?>
  </body>
</html>
</html>
