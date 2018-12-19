<?php
	session_start();
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
	<script src="https://use.fontawwesome.com/d1341f9b7a.js"></script>
<title>fG</title>
	<link rel="stylesheet" type="text/css" href="style/style.css">
</head>

<body>
	<header>
		<nav>
			<div class="main-wrapper">
				<?php
					if(isset($_SESSION['fg_id'])){
						echo '
				<ul>
					<li><a href="index.php">Home</a></li>
					<li><a href="surveys.php">Surveys</a></li>
					<li><a href="games.php">Games</a></li>
					<li><a href="contactus.php">Contact</a></li>
				</ul>
				<div class="nav-login">
					<form action="includes/logout.inc.php" method="post">
						<button type="submit" name="submit">Logout</button>
					</form>';
					} else {
						echo '				
				<ul>
					<li><a href="index.php">Home</a></li>
					<li><a href="surveys.php">Surveys</a></li>
					<li><a href="games.php">Games</a></li>
					<li><a href="contactus.php">Contact</a></li>
				</ul>
				<div class="nav-login">
					<form action="includes/login.inc.php" method="post">
						<input type="text" name="username" placeholder="Username/Email">
						<input type="password" name="pwd" placeholder="Password">
						<button type="submit" name="submit">Login</button>
					</form>
					<a href="signup.php">Sign up</a>
				</div>';
					}
				?>
				
				</div>
			</div>
		</nav>
	</header>
