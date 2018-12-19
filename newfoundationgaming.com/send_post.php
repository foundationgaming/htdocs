<?php 
include ("inc/connect.inc.php");
$post = $_POST['post'];
if ($post != "") {
	$date_added = date("Y-m-d");
	$added_by = "test123";
	$user_posted_to = "Virus";
	$sqlcommand = "INSERT INTO posts VALUES ('','$post','$date_added', '$added_by', '$user_posted_to')";
	$query = mysqli_query($conn, $sqlcommand) or die(mysql_error());
}
else
{
	echo "You must add something before you can post it!";
}
?>