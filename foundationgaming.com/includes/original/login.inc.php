<?php

session_start();

if(isset($_POST['submit'])){
	include 'dbh.inc.php';
	
	$uid = mysqli_real_escape_string($conn, $_POST['username']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
	
	if(empty($uid) || empty($pwd)){
		header("Location: ../index.php?login=empty");
		exit();
	} else {
		$sql = "SELECT * FROM fg_users WHERE username ='".$uid."' OR email ='".$uid."'";
		$result = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($result);
		if($resultCheck < 1) {
			header("Location: ../index.php?login=errornouser");
			exit();
		} else {
			if($row = mysql_fetch_assoc($result)) {
				//DE-HASHING PWD
				$hashedPwdCheck = password_verify($pwd, $row['pswrd']);
				if($hashedPwdCheck == false) {
					header("Location: ../index.php?login=errorpwd");
					exit();
				} elseif ($hashedPwdCheck == true) {
					$_SESSION['fg_id'] = $row['fg_id'];
					$_SESSION['firstName'] = $row['firstName'];
					$_SESSION['lastName'] = $row['lastName'];
					$_SESSION['emailAddress'] = $row['emailAddress'];
					$_SESSION['username'] = $row['username'];
					$_SESSION['gender'] = $row['gender'];
					$_SESSION['profilePic'] = $row['profilePic'];
					header("Location: ../profile.php?login=success");
					exit();
				}
			}
		}
	}
} else {
	header("Location: ../index.php?login=error");
	exit();
}

?>