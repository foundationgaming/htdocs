<?php
session_start();
if(isset($_POST['submit'])) {
	
	include_once 'dbh.inc.php';
	
	$first = mysqli_real_escape_string($conn, $_POST['first']);
	$last = mysqli_real_escape_string($conn, $_POST['last']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
	$gender = mysqli_real_escape_string($conn, $_POST['gender']);
	$hash = mysqli_real_escape_string(md5(rand(0,1000)));
	
	//ERROR HANDLERS
	//CHECK FOR EMPTY FIELDS
	if(empty($first) || empty($last) || empty($email) || empty($username) || empty($pwd)){
		header("Location: ../signup.php?signup=empty");
		exit();	
	} else {
		//CHECK IF INPUT CHARACTERS ARE VALID
		if(!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last)) {
			header("Location: ../signup.php?signup=invalid");
			exit();	
		} else {
			//CHECK EMAIL VALID
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				header("Location: ../signup.php?signup=email");
				exit();	
			} else {
				//CHECK FOR USERS WITH THAT USERNAME
				$sqlcheck = "SELECT * FROM fg_users WHERE username = '$username'";
				$result = mysqli_query($conn, $sqlcheck);
				$resultCheck = mysqli_num_rows($result);
				
				if($resultCheck > 0) {
					header("Location: ../signup.php?signup=usernametaken");
					exit();	
				} else {
					//MAKE SURE GENDER IS CHOSEN
					if($gender == "null"){
						header("Location: ..signup.php?signup=gender");
					} else {
					//HASH THE PASSWORD
					$hashedpwd = password_hash($pwd, PASSWORD_DEFAULT);
					$sqladd = mysqli_query($conn, "INSERT INTO fg_users (firstName, lastName, emailAddress, username, pswrd, hash) VALUES ('$first','$last','$email','$username','$hashedpwd','$hash')");
					
						//SET SESSION INFO
						
						//SEND CONFIRMATION EMAIL
						$subject = 'Account Verification (foundationgaming.com)';
						$message_body = '
						Hello '.$first.',
						
						Thank you for your registration with Foundation Gaming!
						
						please click the link below to activate your account:
						
						http//www.foundationgaming.com/includes/verifyaccount.php?email='.$email.'&hash='.$hash.'
						
						Once confirmed, you can use your login to edit your profile, update your information and more!
						
						Thank you for connecting with us at Foundation Gaming.';
						
						mail($email, $subject, $message_body);
						header("Location: ../profile.php");
					}
				}
			}
		}
	}
	
} else {
	header("Location: ../signup.php");
	exit();
}

?>