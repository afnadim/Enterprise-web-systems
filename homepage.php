<?php
/*
//Author:S M ABDULLAH FERDOUS
//Part of the CM4025 Enterprise web systems
//This file will generate the homepage for the user once user log in successfully
*/
include_once 'includes/dbh.inc.php';
//including top-cache file as we want to genrate a local cache for this file
include "top-cache.php";
//getting the header file
require "header.php";
 ?>
<html>
	<head>
		<title>RSS Heaven</title>
	</head>
	<body>
<!--generating form where user can submit the rss link and set a title for that RSS feed-->
<h2>Add New rss feed and Title</h2>
<form action="includes/rss.inc.php" method="post">
<input type="text" name="feed_link" placeholder="paste your link here">
<input type="text" name="feed_title" placeholder="Set title of your Link">
<button type="submit" name="feed-submit">submit</button></form>
<h2>Your rss feeds</h2>

<?php
//getting the current users name and last logout time
$username = $_SESSION['userUid'];
$lastLogout = $_SESSION['lastlogout'];
$rss_id;
//connceting with the database to retrive users saves rss feed links
$sql="SELECT * FROM rssFeeds WHERE userName=?;";
$stmt=mysqli_stmt_init($connection);
if (!mysqli_stmt_prepare($stmt,$sql)) {
	header("Location: ../index.php?error=sqlerror");
	exit();
}
else{
  //getting the feeds and displaying onto users page
	mysqli_stmt_bind_param($stmt,"s",$username);
	mysqli_stmt_execute($stmt);
	$result=mysqli_stmt_get_result($stmt);

	//going trough the list of users rss feeds in the database and retriveing
  // all the feeds againt that users name
	while ($row= mysqli_fetch_assoc($result)) {
	 $item=$row['rssLink'];
   $rss_id=$row['id'];

   //displaying the titile of the rss feed saved by the user
   $rss_title=$row['rssTitle'];
   echo "<h5>$rss_title</h5>";

   //generateing a delet button so user can delete the feed if they want
   //assining the unique id of the rss link as the value of the button.
   //so once user click on the button that rss link get deleted from the database
  echo"<form action='includes/rss.inc.php' method='post'>
  <button type='submit' value='$rss_id' name='feed-delete'>Delete this feed</button></form>";
  echo'<p class="h7">Displaying most recent five articles</p>';

	//displaying rss feeds
  //creating dom document
	 $rss = new DOMDocument();
   //loading the feed
	 $rss->load($item);
	 $feed = array();
   //getting the article informations from the feed
	 foreach ($rss->getElementsByTagName('item') as $node) {
		 $item = array (
			 'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
			 'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
			 'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
			 'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,

			 );

		 array_push($feed, $item);
	 }

   //showing last 5 news article
	 $limit = 5;
	 for($x=0;$x<$limit;$x++) {
		 $title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
		 $link = $feed[$x]['link'];
		 $description = $feed[$x]['desc'];
		 $date = date('l F d, Y', strtotime($feed[$x]['date']));
     //this will convert Published time into timestamp
     $pub_timestamp = date(strtotime($feed[$x]['date']));
    //checking the Published timestamp with lastlogout timestamp and displying
    // a message with the new items since last logout.
    if($pub_timestamp>$lastLogout){
     echo'<p class="h9">---------------------------------------------</p>';
     echo "<h4>Update!!!:This Article is new and Published since your last login<h4>";
		 echo '<p><h6><strong><a href="'.$link.'" title="'.$title.'">'.$title.'</a><h6></strong><br />';
		 echo '<small><em>Posted on '.$date.'</em></small></p>';
		 echo '<p class="h8">'.$description.'</p>';
   }
   else{
     echo'<p class="h9">---------------------------------------------</p>';
     echo '<p><h6><strong><a href="'.$link.'" title="'.$title.'">'.$title.'</a><h6></strong><br />';
		 echo '<small><em>Posted on '.$date.'</em></small></p>';
		 echo '<p class="h8">'.$description.'</p>';
   }
		}
	}

	}
  //including the bottom cache file as we are creating local caching for this file
  include "bottom-cache.php";

?>



</body>
</html>
