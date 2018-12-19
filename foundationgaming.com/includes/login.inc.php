 <?php

session_start();
 
 if(isset($_POST['submit'])){

	 include 'dbh.inc.php';
	 
	 $uid = mysqli_real_escape_string($conn, $_POST['username']);
	 $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
 
	//Error handlers
	//Check if fields are empty
	if(empty($uid) || empty($pwd)){
		header("Location: ../index.php?login=empty");
		exit();
	} else {
		$sql = "SELECT * FROM fg_users WHERE username = '$uid' OR emailAddress = '$uid';";
		$result = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($result);
		if($resultCheck < 1){
			header("Location: ../index.php?login=error102");
			exit();
		} else {
			if($row = mysqli_fetch_assoc($result)){
				//De-hashing the password
				$hashedPwdCheck = password_verify($pwd, $row['pswrd']);
				if($hashedPwdCheck == false){
					header("Location: ../index.php?login=error110");
					exit();
				} elseif($hashedPwdCheck == true){
					//Log in the user here
				$_SESSION['fg_id'] = $row['fg_id'];
				$_SESSION['firstName'] = $row['firstName'];
				$_SESSION['lastName'] = $row['lastName'];
				$_SESSION['emailAddress'] = $row['emailAddress'];
				$_SESSION['username'] = $row['username'];
				header("Location: ../index.php?login=success");
				exit();
				}
			}
		}
	}
 } else {
	 header("Location: ../index.php?login=error121");
	 exit();
 }