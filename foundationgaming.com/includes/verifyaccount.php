<?php
	include_once('dbh.inc.php');
	session_start();

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
	$email = mysqli_real_escape_string($_GET['email']);
	$hash = mysqli_real_escape_string($_GET['hash']);
	
	$result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND hash='$hash' AND active='0'");
	if(mysqli_num_rows($result) == 0) {
		$_SESSION['message'] = "Account has already been activated or the URL is invalid!";
		header("Location: ../error.php?url=invalid");
	} else {
		$_SESSION['message'] = "Account has been activated!";
		$sql = mysqli_query($conn, "UPDATE fg_users SET active='1' WHERE emailAddress = '.$email.'");
		$_SESSION['active'] = 1;
		header("Location: ../profile.php?activation=success");
	}
} else {
	$_SESSION['messafe'] = "UNKNOWN PARAMETERS FOR ACCOUNT VERIFICATION!";
	header("Location: ../error.php?validation=error");
}
?>