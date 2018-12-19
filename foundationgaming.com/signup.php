<?php
	include_once 'header.php';
?>
	<section class="main-container">
		<div class="main-wrapper">
			<h2>Sign Up</h2>
			<form class="signup-form" action="includes/signup.inc.php" method="post">
				<input type="text" name="first" placeholder="Firstname">
				<input type="text" name="last" placeholder="Lastname">
				<input type="text" name="email" placeholder="e-mail">
				<input type="text" name="username" placeholder="Username">
				<input type="password" name="pwd" placeholder="Passwword">
				<select name="gender">
					<option value="null">Gender you identify as:</option>
					<option value="male">Male</option>
					<option value="female">Female</option>
					<option value="other">Other</option>
				</select>
				<button type="submit" name="submit">Sign up</button>
			</form>
		</div>
	</section>

<?php
	include 'footer.php';
?>