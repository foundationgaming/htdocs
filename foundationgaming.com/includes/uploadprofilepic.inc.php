<?php

session_start();
include 'dbh.inc.php';

$picName = "picture".$_SESSION['fg_id']."profile".$_FILES['image']['name'];
$target = "../profilepictures/".$picName."";
$sql = mysqli_query($conn, "UPDATE fg_users SET profilePic = '".$picName."' WHERE fg_id = '".$_SESSION['fg_id']."'");

if(move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
	
}

header("Location: ../profile.php");
	
?>