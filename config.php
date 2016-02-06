<!-- 
www.vnlisting.com
Online Super Bowl Squares Script
Please read the "Readme.txt for license agreement, installtion and usage instructions 
-->

<?php
error_reporting(0);
// Full URL path to your superbowl. ex. www.yoursite.com/superbowl
$superbowlURL = "http://www.yoursite.com/superbowl";

//make changes accordingly to your database
$hostname = "localhost";
$database = "superbowl";
$username = "root";
$password = "cash009";
$db = mysql_connect($hostname, $username, $password);
$db_select = mysql_select_db($database, $db) or mysql_error();
?>
