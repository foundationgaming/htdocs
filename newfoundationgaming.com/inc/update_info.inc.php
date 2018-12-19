<?php
session_start();
$user = $_SESSION['username'];
if(isset($_POST['senddata'])) {
	include_once 'connect.inc.php';
	$oldpwd = mysqli_real_escape_string($conn, @$_POST['oldpassword']);
	$newpwd = mysqli_real_escape_string($conn, @$_POST['newpassword']);
	$confpwd = mysqli_real_escape_string($conn, @$_POST['confpassword']);
	$fname = mysqli_real_escape_string($conn, @$_POST['fname']);
	$lname = mysqli_real_escape_string($conn, @$_POST['lname']);
	$email = mysqli_real_escape_string($conn, @$_POST['email']);
	$bio = mysqli_real_escape_string($conn, @$_POST['aboutyou']);
	$pc = mysqli_real_escape_string($conn, @$_POST['pc']);
	$pcstats = mysqli_real_escape_string($conn, @$_POST['pcstats']);
	$pcf1 = mysqli_real_escape_string($conn, @$_POST['pcf1']);
	$pcf2 = mysqli_real_escape_string($conn, @$_POST['pcf2']);
	$pcf3 = mysqli_real_escape_string($conn, @$_POST['pcf3']);
	$pcf4 = mysqli_real_escape_string($conn, @$_POST['pcf4']);
	$pcf5 = mysqli_real_escape_string($conn, @$_POST['pcf5']);
	$xb = mysqli_real_escape_string($conn, @$_POST['xb']);
	$xbf1 = mysqli_real_escape_string($conn, @$_POST['xbf1']);
	$xbf2 = mysqli_real_escape_string($conn, @$_POST['xbf2']);
	$xbf3 = mysqli_real_escape_string($conn, @$_POST['xbf3']);
	$xbf4 = mysqli_real_escape_string($conn, @$_POST['xbf4']);
	$xbf5 = mysqli_real_escape_string($conn, @$_POST['xbf5']);
	$ps = mysqli_real_escape_string($conn, @$_POST['ps']);
	$psf1 = mysqli_real_escape_string($conn, @$_POST['psf1']);
	$psf2 = mysqli_real_escape_string($conn, @$_POST['psf2']);
	$psf3 = mysqli_real_escape_string($conn, @$_POST['psf3']);
	$psf4 = mysqli_real_escape_string($conn, @$_POST['psf4']);
	$psf5 = mysqli_real_escape_string($conn, @$_POST['psf5']);
	$hh = mysqli_real_escape_string($conn, @$_POST['hh']);
	$hhstats = mysqli_real_escape_string($conn, @$_POST['hhstats']);
	$hhf1 = mysqli_real_escape_string($conn, @$_POST['hhf1']);
	$hhf2 = mysqli_real_escape_string($conn, @$_POST['hhf2']);
	$hhf3 = mysqli_real_escape_string($conn, @$_POST['hhf3']);
	$hhf4 = mysqli_real_escape_string($conn, @$_POST['hhf4']);
	$hhf5 = mysqli_real_escape_string($conn, @$_POST['hhf5']);
	
	$sql = "SELECT * FROM users WHERE username='$user'";
	$query = mysqli_query($conn, $sql);

	while ($row = mysqli_fetch_assoc($query)) {
		$dbpwd = $row['password'];
		$dbfname = $row['first_name'];
		$dblname = $row['last_name'];
		$dbemail = $row['email'];
		$dbbio = $row['bio'];
		$dbgear = $row['gear'];
		//encrypt old pwd
		$existing = crypt($oldpwd,'$6$rounds=5000$'.$row['salt'].'$');
		if ($oldpwd != "" && $existing == $dbpwd) {
			//same pwd so change password
			//check if new passwords match
			if ($newpwd == $confpwd) {
				//Passwords match
				//encrypt new pwd
				$postpwd = crypt($newpwd,'$6$rounds=5000$'.$row['salt'].'$');
				//Replace old password with ^^this^^
				$pwdupdate = mysqli_query($conn, "UPDATE users SET password='$postpwd' WHERE username='$user'");
			}
		} else {
			//Passwords don't match
		}
		if ($fname != "" && $fname != $dbfname) {
			$fnameupdate = mysqli_query($conn, "UPDATE users SET first_name='$fname' WHERE username='$user'");
		}
		if ($lname != "" && $lname != $dblname) {
			$lnameupdate = mysqli_query($conn, "UPDATE users SET last_name='$lname' WHERE username='$user'");
		}
		if ($email != "" && $email != $dbemail) {
			$emailupdate = mysqli_query($conn, "UPDATE users SET email='$email' WHERE username='$user'");
		}
		if ($bio != "" && $bio != $dbbio) {
			$bioupdate = mysqli_query($conn, "UPDATE users SET bio='$bio' WHERE username='$user'");
		}
		if ($pc == 'yes'){
			$pcupdate = mysqli_query($conn, "UPDATE users SET pc='YES', pcstats='$pcstats', pcf1='$pcf1', pcf2='$pcf2', pcf3='$pcf3', pcf4='$pcf4', pcf5='$pcf5' WHERE username='$user'");
		} else {
			$pcupdate = mysqli_query($conn, "UPDATE users SET pc='NO', pcstats='', pcf1='', pcf2='', pcf3='', pcf4='', pcf5='' WHERE username='$user'");
		}
		if ($xb == 'yes'){
			$xbupdate = mysqli_query($conn, "UPDATE users SET xb='YES', xbf1='$xbf1', xbf2='$xbf2', xbf3='$xbf3', xbf4='$xbf4', xbf5='$xbf5' WHERE username='$user'");
		} else {
			$xbupdate = mysqli_query($conn, "UPDATE users SET xb='NO', xbf1='', xbf2='', xbf3='', xbf4='', xbf5='' WHERE username='$user'");
		}
		if ($ps == 'yes'){
			$psupdate = mysqli_query($conn, "UPDATE users SET ps='YES', psf1='$psf1', psf2='$psf2', psf3='$psf3', psf4='$psf4', psf5='$psf5' WHERE username='$user'");
		} else {
			$psupdate = mysqli_query($conn, "UPDATE users SET ps='NO', psf1='', psf2='', psf3='', psf4='', psf5='' WHERE username='$user'");
		}
		if ($hh == 'yes'){
			$hhupdate = mysqli_query($conn, "UPDATE users SET hh='YES', hhstats='$hhstats', hhf1='$hhf1', hhf2='$hhf2', hhf3='$hhf3', hhf4='$hhf4', hhf5='$hhf5' WHERE username='$user'");
		} else {
			$hhupdate = mysqli_query($conn, "UPDATE users SET hh='NO', hhstats='', hhf1='', hhf2='', hhf3='', hhf4='', hhf5='' WHERE username='$user'");
		}
		header("location: ../".$_SESSION['username']."?settings_update=success");
	}
}
else {
	header("location: ../".$_SESSION['username']."?error=error_submitting");
}
?>