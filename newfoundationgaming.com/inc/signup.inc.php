<?php

if(isset($_POST['submit'])) {
	
	include_once 'connect.inc.php';
	
	$first = mysqli_real_escape_string($conn, $_POST['fname']);
	$last = mysqli_real_escape_string($conn, $_POST['lname']);
	$uid = mysqli_real_escape_string($conn, $_POST['uname']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$email2 = mysqli_real_escape_string($conn, $_POST['email2']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
	$pwd2 = mysqli_real_escape_string($conn, $_POST['pwd2']);
	$salt = md5(@$first."gamersUnite");
	$d = date("Y-m-d");	//Year - Month - day
	
	//Error handlers
	//Check for empty fields
	if ($email != $email2) {
		header("Location: ../index.php?signup=emailmissmatch");
		exit();
	} else {
		if ($pwd != $pwd2) {
			header("Location: ../index.php?signup=emailmissmatch");
		exit();
		} else {
			if(empty($first) || empty($last) || empty($email) || empty($uid) || empty($pwd) ){
				header("Location: ../index.php?signup=empty");
				exit();
			} else {
				//Check if email is valid
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
					header("Location: ../index.php?signup=email");
					exit();
				} else {
					//Check if username exists
					$sql = "SELECT * FROM users WHERE username ='$uid'";
					$result = mysqli_query($conn, $sql);
					$resultCheck = mysqli_num_rows($result);
					
					if($resultCheck > 0){
						header("Location: ../index.php?signup=user_taken");
						exit();
					} else {
						//Encrypting the password
						$finalpwd = crypt($pwd,'$6$rounds=5000$'.$salt.'$');
						//Insert the user into the database
						$sql = "INSERT INTO users (username, first_name, last_name, email, password, salt, sign_up_date, activated) VALUES ('$uid', '$first', '$last', '$email', '$finalpwd', '$salt', $d, '0')";
						mysqli_query($conn, $sql);
						header("Location: ../index.php?signup=success");
						exit();
					}
				}
			}
		}
	}
} else {
	header("Location: ../index.php");
	exit();
}