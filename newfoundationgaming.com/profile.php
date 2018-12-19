<?php 
	include ("inc/header.inc.php");
?>
<?php 
if (isset($_GET['u'])) {
	$username = mysqli_real_escape_string($conn, $_GET['u']);
	if (ctype_alnum($username)) {
		//check the user exists

		$check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
		if (mysqli_num_rows($check)===1) {
			$get = mysqli_fetch_assoc($check);
			$username = $get['username'];
			$firstname = $get['first_name'];
			$pc = $get['pc'];
			$pcstats = $get['pcstats'];
			$pcf1 = $get['pcf1'];
			$pcf2 = $get['pcf2'];
			$pcf3 = $get['pcf3'];
			$pcf4 = $get['pcf4'];
			$pcf5 = $get['pcf5'];
			$xb = $get['xb'];
			$xbf1 = $get['xbf1'];
			$xbf2 = $get['xbf2'];
			$xbf3 = $get['xbf3'];
			$xbf4 = $get['xbf4'];
			$xbf5 = $get['xbf5'];
			$ps = $get['ps'];
			$psf1 = $get['psf1'];
			$psf2 = $get['psf2'];
			$psf3 = $get['psf3'];
			$psf4 = $get['psf4'];
			$psf5 = $get['psf5'];
			$hh = $get['hh'];
			$hhstats = $get['hhstats'];
			$hhf1 = $get['hhf1'];
			$hhf2 = $get['hhf2'];
			$hhf3 = $get['hhf3'];
			$hhf4 = $get['hhf4'];
			$hhf5 = $get['hhf5'];
		}
		else
		{
			echo "<meta http-equiv=\"refresh\" content=\"0; url=http://http://localhost/newfoundationgaming.com/index.php\">";
			exit();
		}
	}
}
?>
<div id="wrapper" style="background-color:#333235;width:800px;">
<div class="postForm">
	<textarea id="post" name="post" rows="5" cols="90" placeholder="What do you want to share with the world?" style="background-color: #DDDED9;"></textarea>
	<input type="submit" name="send" onclick="javascript:send_post()" value="Post" >
</div>
<div class="profilePosts">
	<?php 
	$getposts = mysqli_query($conn, "SELECT * FROM posts WHERE added_by='$username' ORDER BY id DESC LIMIT 10");
	while ($row = mysqli_fetch_assoc($getposts)) {
		$id = $row['id'];
		$body = $row['body'];
		$date_added = $row['date_added'];
		$added_by = $row['added_by'];
		$user_posted_to = $row['user_posted_to'];
		echo "<div class='posted_by'><a href='$added_by'>$added_by</a> - $date_added</div><br/><br/><div class='wallpost'>$body</div><br/><hr/>";
	}
	?>
</div>
<img src="#" height="250" width="200" alt="<?php echo $username?>'s Profile Picture" title="<?php echo $username?>">
</br>
<div class="textHeader"><?php echo $username; ?>'s Profile</div>
<div class="profileLeftSideContent">
	<?php 
	$getbio = "SELECT bio FROM users WHERE username='$username'";
	$getbioquery = mysqli_query($conn, $getbio);
	$getbioresult = mysqli_fetch_assoc($getbioquery);
	$getbiofinal = $getbioresult['bio'];
	echo $getbiofinal;
	?>
</div>
<?php 
if ($pc == 'YES') {
	echo "<div class='textHeader'>".$username."'s PC</div>
	<div class='profileLeftSideContent'>
		".$pcstats."<br>
		
		<div class='textHeader'>My top 5 PC games are:</div>
		".$pcf1."<br>
		".$pcf2."<br>
		".$pcf3."<br>
		".$pcf4."<br>
		".$pcf5."<br>
		<br>
	</div>";
}
if ($xb == 'YES') {
	echo "<div class='textHeader'>".$username."'s xBox</div>
	<div class='profileLeftSideContent'>
		<div class='textHeader'>My top 5 xBox games are:</div>
		".$xbf1."<br>
		".$xbf2."<br>
		".$xbf3."<br>
		".$xbf4."<br>
		".$xbf5."<br>
		<br>
	</div>";
}
if ($ps == 'YES') {
	echo "<div class='textHeader'>".$username."'s Play Station</div>
	<div class='profileLeftSideContent'>
		<div class='textHeader'>My top 5 Play Station games are:</div>
		".$psf1."<br>
		".$psf2."<br>
		".$psf3."<br>
		".$psf4."<br>
		".$psf5."<br>
		<br>
	</div>";
}
if ($hh == 'YES') {
	echo "<div class='textHeader'>".$username."'s Hand Held</div>
	<div class='profileLeftSideContent'>
		<div class='textHeader'>I own a:</div>
		".$hhstats."<br>
		
		<div class='textHeader'>My top 5 ".$hhstats." games are:</div>
		".$hhf1."<br>
		".$hhf2."<br>
		".$hhf3."<br>
		".$hhf4."<br>
		".$hhf5."<br>
		<br>
	</div>";
}?>
<div class="textHeader"><?php echo $username; ?>'s Friends</div>
<div class="profileLeftSideContent">
	<img src="#" height="50" width="40">&nbsp;
	<img src="#" height="50" width="40">&nbsp;
	<img src="#" height="50" width="40">&nbsp;
	<img src="#" height="50" width="40">&nbsp;
	<img src="#" height="50" width="40">&nbsp;
	<img src="#" height="50" width="40">&nbsp;
	<img src="#" height="50" width="40">&nbsp;
	<img src="#" height="50" width="40">&nbsp;
</div>
</div>