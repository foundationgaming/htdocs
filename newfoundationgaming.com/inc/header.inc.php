<?php 
include ("inc/connect.inc.php"); 
session_start();
if (!isset($_SESSION['id'])) {
	echo '<!doctype html>
	<html>
		<head>
			<title></title>
			<!-- bootstrap -->
		<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">
		<!-- bootstrap theme -->
		<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap-theme.min.css">
		<!-- font awesome -->
		<link rel="stylesheet" type="text/css" href="assets/font-awesome/css/fontawesome.min.css">
		<!-- custom css -->
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<!-- bootstrap.js -->
		<script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
		<!-- main.js -->
		<script type="text/javascript" src="js/main.js"></script>
		</head>
		<body style="background-color: #323335">
			<div class="headerMenu">
				<div id="wrapper">
					<div class="logo">
						<img src="img/gamersUnite.png">
					</div>
					<div class="searchbox">
						<form method="GET" action="search.php" id="search">
							<input type="text" name="q" size="60" placeholder="Find..."/>
						</form>
					</div>
					<div id="menu">
						<a href="index.php">Home</a>
						<a href="about.php">About</a>
						<a href="index.php?register=below">Register</a>
						<a href="index.php?login=below">Sign In</a>
					</div>
				</div>
			</div>';
}
else
{
	echo '
	<!doctype html>
	<html>
		<head>
			<title></title>
			<!-- bootstrap -->
		<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">
		<!-- bootstrap theme -->
		<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap-theme.min.css">
		<!-- font awesome -->
		<link rel="stylesheet" type="text/css" href="assets/font-awesome/css/fontawesome.min.css">
		<!-- custom css -->
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<!-- bootstrap.js -->
		<script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
		<!-- main.js -->
		<script type="text/javascript" src="js/main.js"></script>
		</head>
		<body style="background-color: #323335">
			<div class="headerMenu">
				<div id="wrapper">
					<div class="logo">
						<img src="img/gamersUnite.png">
					</div>
					<div class="searchbox">
						<form method="GET" action="search.php" id="search">
							<input type="text" name="q" size="60" placeholder="Find..."/>
						</form>
					</div>
					<div id="menu">
						<a href="home.php">My Profile</a>
						<a href="about.php">About</a>
						<a href="account_settings.php">Account Settings</a>
						<a href="inc/logout.inc.php">Logout</a>
					</div>
				</div>
			</div>';
}
?>
