<?php
	include_once('header.php');
?>

<form class="signup-form" action="includes/uploadprofilepic.inc.php" method="post" enctype="multipart/form-data">
	<input type="file" name="image">
	<button type="submit" name="submit">Upload Picture</button>
</form>

<?php

include('footer.php');