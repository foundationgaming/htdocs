<?php
if (isset($_POST['submit'])) {
	include_once 'dbh.inc.php';
	$first = mysqli_real_escape_string($conn, $_POST['first']);
	$last = mysqli_real_escape_string($conn, $_POST['last']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

	/*ERROR HANDLERS*/
	/*CHECK FOR EMPTY FIELDS*/
	if (empty($first) || empty($last) || empty($email) || empty($username) || empty($pwd)) {
		header("Location: ../signup.php?signup=empty");
		exit();
	} else {
		/*CHECK IF INPUT CHARACTER ARE VALID*/
		if (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last)) {
			header("Location: ../signup.php?signup=invalid");
			exit();
		} else {
			/*CHECK IF EMAIL IS VALID*/
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				header("Location: ../signup.php?signup=email");
				exit();
			} else {
				/*CHECK IF USERNAME IS AVAILABLE*/
				$sql = "SELECT * FROM users WHERE u_userName ='$username'";
				$result = mysqli_query($conn, $sql);
				$resultCheck = mysqli_num_rows($result);
				if ($resultCheck > 0) {
					header("Location: ../signup.php?signup=usernametaken");
					exit();
				} else {
					/*ENCRYPT PASSWORD*/
					$salt = md5(@$first."fire".$last);
					$newpwd = crypt($pwd,'$6$rounds=5000$'.$salt.'$');
					/*INSERT USER INTO THE DATABASE*/
					$sql = "INSERT INTO users (u_userName, u_firstName, u_lastName, u_email, u_salt, u_pwd) VALUES ('$username', '$first', '$last', '$email', '$salt', '$newpwd')";
					$result = mysqli_query($conn, $sql);
					header("Location: ../index.php");
				}
			}
		}
	}
} else {
	header("Location: ../signup.php");
	exit();
}