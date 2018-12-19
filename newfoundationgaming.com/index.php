<?php
include ("inc/header.inc.php");
if (!isset($_SESSION['id'])) {
	
}
else
{
	header("location: home.php");
}
?>
		<div style="width: 800px; margin: 0px auto 0px auto;">
			<table>
				<tr>
					<td width="60%" valign="top">
						<h2>Already a member? Sign in below!</h2>
						<form action="inc/login.inc.php" method="POST">
							<input type="text" name="uname_login" size="25" placeholder="Username"><br><br>
							<input type="password" name="pwd_login" size="25" placeholder="Password"><br><br>
							<input type="submit" name="submit" value="SignUp!">
						</form>
					</td>
					<td width="40%" valign="top">
						<h2>Sign Up today!</h2>
						<form action="inc/signup.inc.php" method="POST">
							<input type="text" name="fname" size="25" placeholder="First Name"><br><br>
							<input type="text" name="lname" size="25" placeholder="Last Name"><br><br>
							<input type="text" name="uname" size="25" placeholder="Username"><br><br>
							<input type="text" name="email" size="25" placeholder="Email Address"><br><br>
							<input type="text" name="email2" size="25" placeholder="Confirm Email"><br><br>
							<input type="password" name="pwd" size="25" placeholder="Password"><br><br>
							<input type="password" name="pwd2" size="25" placeholder="Confirm Password"><br><br>
							<input type="submit" name="submit" value="SignUp!">
						</form>
					</td>
				</tr>
			</table>
<?php include ("inc/footer.inc.php"); ?>