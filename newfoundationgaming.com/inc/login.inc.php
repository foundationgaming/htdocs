 <?php

session_start();
 
 if(isset($_POST['submit'])){

	 include 'connect.inc.php';
	 
	 $uid = mysqli_real_escape_string($conn, $_POST['uname_login']);
	 $pwd = mysqli_real_escape_string($conn, $_POST['pwd_login']);
 
	//Error handlers
	//Check if fields are empty
	if(empty($uid) || empty($pwd)){
		header("Location: ../index.php?login=empty");
		exit();
	} else {
		$sql = "SELECT * FROM users WHERE username = '$uid' OR email = '$uid';";
		$result = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($result);
		if($resultCheck < 1){
			header("Location: ../index.php?login=error102");
			exit();
		} else {
			if($row = mysqli_fetch_assoc($result)){
				//De-hashing the password
				$pwd_login = crypt($pwd,'$6$rounds=5000$'.$row['salt'].'$');
				if($pwd_login!=$row['password']){
					header("Location: ../index.php?login=error110");
					exit();
				} else {
					//Log in the user here
				$_SESSION['id'] = $row['id'];
				$_SESSION['username'] = $row['username'];
				$_SESSION['firstname'] = $row['first_name'];
				$_SESSION['lastname'] = $row['last_name'];
				$_SESSION['email'] = $row['email'];
				$_SESSION['pc'] = $row['pc'];
				$_SESSION['pcstats'] = $row['pcstats'];
				$_SESSION['pcf1'] = $row['pcf1'];
				$_SESSION['pcf2'] = $row['pcf2'];
				$_SESSION['pcf3'] = $row['pcf3'];
				$_SESSION['pcf4'] = $row['pcf4'];
				$_SESSION['pcf5'] = $row['pcf5'];
				$_SESSION['xb'] = $row['xb'];
				$_SESSION['xbf1'] = $row['xbf1'];
				$_SESSION['xbf2'] = $row['xbf2'];
				$_SESSION['xbf3'] = $row['xbf3'];
				$_SESSION['xbf4'] = $row['xbf4'];
				$_SESSION['xbf5'] = $row['xbf5'];
				$_SESSION['ps'] = $row['ps'];
				$_SESSION['psf1'] = $row['psf1'];
				$_SESSION['psf2'] = $row['psf2'];
				$_SESSION['psf3'] = $row['psf3'];
				$_SESSION['psf4'] = $row['psf4'];
				$_SESSION['psf5'] = $row['psf5'];
				$_SESSION['hh'] = $row['hh'];
				$_SESSION['hhstats'] = $row['hhstats'];
				$_SESSION['hhf1'] = $row['hhf1'];
				$_SESSION['hhf2'] = $row['hhf2'];
				$_SESSION['hhf3'] = $row['hhf3'];
				$_SESSION['hhf4'] = $row['hhf4'];
				$_SESSION['hhf5'] = $row['hhf5'];
				header("Location: ../home.php?login=success");
				exit();
				}
			}
		}
	}
 } else {
	 header("Location: ../index.php?login=error121");
	 exit();
 }