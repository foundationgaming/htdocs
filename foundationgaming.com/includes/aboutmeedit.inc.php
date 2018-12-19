<?php

session_start();
include('dbh.inc.php');

$aboutMe = mysqli_real_escape_string($conn, $_POST['aboutme']);

if(isset($_POST['submit'])) {
	$sql = mysqli_query($conn, "UPDATE fg_users SET aboutMe ='".$aboutMe."' WHERE fg_id = '".$_SESSION['fg_id']."'");
} else {
	header("Location: ../profile.php");
}

?>