<?php

if(isset($_POST['submit'])) {
	
	include_once 'dbh.inc.php';
	
	$first = mysqli_real_escape_string($conn, $_POST['first']);
	$last = mysqli_real_escape_string($conn, $_POST['last']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$uid = mysqli_real_escape_string($conn, $_POST['username']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
	$gender = mysqli_real_escape_string($conn, $_POST['gender']);
	
	//Error handlers
	//Check for empty fields
	if(empty($first) || empty($last) || empty($email) || empty($uid) || empty($pwd) ){
		header("Location: ../signup.php?signup=empty");
		exit();
	} else {
		//Check if input characters are valid
	if(!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last)){
			header("Location: ../signup.php?signup=invalid");
			exit();
		} else {
			//Check if email is valid
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				header("Location: ../signup.php?signup=email");
				exit();
			} else {
				//Check if username exists
				$sql = "SELECT * FROM fg_users WHERE username ='$uid'";
				$result = mysqli_query($conn, $sql);
				$resultCheck = mysqli_num_rows($result);
				
				if($resultCheck > 0){
					header("Location: ../signup.php?signup=user_taken");
					exit();
				} else {
					//Hashing the password
					$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
					//Insert the user into the database
					$sql = "INSERT INTO fg_users (firstName, lastName, emailAddress, username, pswrd, gender) VALUES ('$first', '$last', '$email', '$uid', '$hashedPwd', '$gender')";
					mysqli_query($conn, $sql);
					header("Location: ../signup.php?signup=success");
					exit();
				}
			}
		}
	}
} else {
	header("Location: ../signup.php");
	exit();
}