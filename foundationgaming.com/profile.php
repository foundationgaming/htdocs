<?php

include_once('header.php');
include_once('includes/dbh.inc.php');

$id = $_SESSION['fg_id'];


$sql = mysqli_query($conn, "SELECT * FROM fg_users WHERE fg_id ='$id'");
$row = mysqli_fetch_array($sql);

?>
<div class="profile-card">
	<div class="prof-header">
		<?php 
			if(empty($row['profilePic'])) {
					echo "<img class='profilePic' src='profilepictures/".$row['profilePic']."' alt='Profile Picture'>";
				} else {
				echo $row['profilePic'];
			}
		?>
	</div>
	<div class="upload-profile-pic">
		<a href="uploadprofilepic.php">Upload New Profile Pic</a>
	</div>
	<div class="prof-content">
		<h3><?php echo $_SESSION['username'];?></h3>
		<p>
			<?php
				if(empty($row['aboutMe'])) {
					echo '
						<form class="editaboutme" action="includes/aboutmeedit.inc.php" method="post">
							<textarea class="aboutmeedittext" name="aboutme" maxlength="500" placeholder="Enter something about you...

Include your favorite games and platforms!"></textarea>
							<button class="aboutmefinbutton" type="submit" name="submit">Submit!</button>
						</form>
					';
				} else {
					echo $row['aboutMe'];
				}
			?>
		</p>
	</div>
</div>

<?php

include 'footer.php';

?>