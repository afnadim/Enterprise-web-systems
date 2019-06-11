<?php
/*
//Author:S M ABDULLAH FERDOUS
//Part of the CM4025 Enterprise web systems
//This file is to use caching up the website for better performance
*/

//creating a cache file and name it accordingly with the file we are acching
$url = $_SERVER["SCRIPT_NAME"];
$break = Explode('/', $url);
$file = $break[count($break) - 1];
$cachefile = 'cached-'.substr_replace($file ,"",-4).'.html';
//set the interval time of caching
$cachetime = 1;

// Serve from the cache if it is younger than $cachetime
if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
    echo "<!-- Cached copy, generated ".date('H:i', filemtime($cachefile))." -->\n";
    include($cachefile);
    exit;
}
// Starting the output buffer
ob_start();
?>
