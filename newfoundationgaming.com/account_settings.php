<?php include ("inc/header.inc.php"); 
$user = @$_SESSION["username"];
$fname = @$_SESSION["firstname"];
$lname = @$_SESSION["lastname"];
$email = @$_SESSION["email"];
echo $user;
if ($user) {
	
}
else
{
	header("location: index.php");
}?>
<div id="wrapper_settings">
	<h2>Account Settings</h2>
	<hr/>
	<form action="inc/update_info.inc.php" method="POST">
		<div>
			<h3>Change your password</h3>
			<input type="password" name="oldpassword" id="oldPassword" placeholder="Old Password"><br/>
			<input type="password" name="newpassword" id="newpassword" placeholder="New Password"><br/>
			<input type="password" name="confpassword" id="confpassword" placeholder="Confirm Password"><br/>
		</div>
		<hr>
		<div>
			<h3>Update Info</h3>
			<input type="text" name="fname" id="fname" placeholder="First Name"><br/>
			<input type="text" name="lname" id="lname" placeholder="Last Name"><br/>
			<input type="text" name="email" id="email" placeholder="Email"><br/>
		</div>
		<hr>
		<div>
			<h3>About You</h3>
			<textarea name="aboutyou" id="aboutyou" cols="40" rows="7"></textarea><br/>
		</div>
		<hr>
		<div>
			<h3>Your Gear</h3>
			<div class="checkbox_layout">
				<input type="checkbox" name="pc" id="pc" value="yes" onclick="showHidePC()">
				<label for="pc" style="color: #DDDED9;">PC</label><br>
			<fieldset id="personalcomputer" style="display: none;">
				<textarea name="pcstats" id="pcstats" cols="40" rows="7" style="color: #DDDED9;" placeholder="Tell us about your PC!"></textarea><br/>
				<label style="color: #DDDED9;">Tell us your top 5 PC games!</label><br>
				<input type="text" name="pcf1"><br>
				<input type="text" name="pcf2"><br>
				<input type="text" name="pcf3"><br>
				<input type="text" name="pcf4"><br>
				<input type="text" name="pcf5"><br>
			</fieldset>
				<input type="checkbox" name="xb" id="xb" value="yes" onclick="showHidexBox()">
				<label for="xb" style="color: #DDDED9;">xBox</label><br>
			<fieldset id="console_xbox" style="display: none;">
				<label style="color: #DDDED9;">Tell us your top 5 xBox games!</label><br>
				<input type="text" name="xbf1"><br>
				<input type="text" name="xbf2"><br>
				<input type="text" name="xbf3"><br>
				<input type="text" name="xbf4"><br>
				<input type="text" name="xbf5"><br>
			</fieldset>
				<input type="checkbox" name="ps" id="ps" value="yes" onclick="showHidePlayStation()">
				<label for="ps" style="color: #DDDED9;">Play Station</label><br>
			<fieldset id="console_playstation" style="display: none;">
				<label style="color: #DDDED9;">Tell us your top Play Station 5 games!</label><br>
				<input type="text" name="psf1"><br>
				<input type="text" name="psf2"><br>
				<input type="text" name="psf3"><br>
				<input type="text" name="psf4"><br>
				<input type="text" name="psf5"><br>
			</fieldset>
				<input type="checkbox" name="hh" id="hh" value="yes" onclick="showHideHandheld()">
				<label for="handheld" style="color: #DDDED9;">Handheld</label><br>
			<fieldset id="console_handheld" style="display: none;">
				<label style="color: #DDDED9;">What is your handheld?</label><br>
				<input type="text" name="handheldtype" placeholder="Eg. Nintendo 3DS"><br>
				<label style="color: #DDDED9;">Tell us your top Handheld 5 games!</label><br>
				<input type="text" name="hhf1"><br>
				<input type="text" name="hhf2"><br>
				<input type="text" name="hhf3"><br>
				<input type="text" name="hhf4"><br>
				<input type="text" name="hhf5"><br>
			</fieldset>
			</div>
		</div>
		<hr>
		<input type="submit" name="senddata" id="senddata" value="Update Info" onsubmit="addNewLines();">
	</form>
</div>
<script>
	function showHidePC()
	{
		if (document.getElementById('pc').checked) {
			document.getElementById('personalcomputer').style.display='block';
		} else {
			document.getElementById('personalcomputer').style.display='none';
		}
	}
	function showHidexBox()
	{
		if (document.getElementById('xb').checked) {
			document.getElementById('console_xbox').style.display='block';
		} else {
			document.getElementById('console_xbox').style.display='none';
		}
	}
	function showHidePlayStation()
	{
		if (document.getElementById('ps').checked) {
			document.getElementById('console_playstation').style.display='block';
		} else {
			document.getElementById('console_playstation').style.display='none';
		}
	}
	function showHideHandheld()
	{
		if (document.getElementById('hh').checked) {
			document.getElementById('console_handheld').style.display='block';
		} else {
			document.getElementById('console_handheld').style.display='none';
		}
	}
</script>