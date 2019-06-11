<?php
/*
//Author:S M ABDULLAH FERDOUS
//Part of the CM4025 Enterprise web systems
//This file will save the Rss feed and title user sumitted
*/
//cheking if the submit button is clicked and adding a rss feed into the database
if (isset($_POST['feed-submit'])) {
   session_start();
   //getting username from the session
   $username = $_SESSION['userUid'];
   //getting information from the input fields
   $rssFeed= $_POST["feed_link"];
   $rssFeedtitle= $_POST["feed_title"];
   //random id will be generated based on current time
   $id=time().'-'.mt_rand();
   //connection to the database
   $host = "localhost";
   $user = "root";
   $pass = "";
   $database = "loginsystem";
   $results = null;
   $connection  = mysqli_connect($host, $user, $pass, $database)
     or die ("Error is " . $mysqli_error ($connection));

   $username = $connection->real_escape_string ($username);
   $rssFeed= $connection->real_escape_string ($rssFeed);
   $rssFeedtitle= $connection->real_escape_string ($rssFeedtitle);
   $query = "insert into rssFeeds (id,userName,rssLink,rssTitle) values (\"$id\"
   , \"$username\", \"$rssFeed\",\"$rssFeedtitle\")";

   $results = $connection->query ($query);

   echo $connection->error;
  // feed successfully addes and user stays in the homepage
   echo "<p>feed successfully added</p>";
   header("Location: ../homepage.php");
}

//checking if the delete feed button is clicked and deleting a rss feed
if (isset($_POST['feed-delete'])) {
  session_start();
  $username = $_SESSION['userUid'];
  //getting the unique rss id which was assigned as the button value
  $rss_id = $_POST['feed-delete'];
  //conncetion to the database
  $host = "localhost";
  $user = "root";
  $pass = "";
  $database = "loginsystem";
  $connection  = mysqli_connect($host, $user, $pass, $database)
    or die ("Error is " . $mysqli_error ($connection));

  $rss_id= $connection->real_escape_string ($rss_id);
  //deleting the rss from the databse with the unique id
  $query= "DELETE FROM rssFeeds WHERE id=$rss_id;";

  $results = $connection->query ($query);
  echo $connection->error;
//user staying in the homepage 
  echo "<p>feed successfully added</p>";
  header("Location: ../homepage.php");



}



   ?>
