<?php
	include_once('header.php');
?>
<div class="error-div">
	<h1>Error!</h1>
<p>
	<?php
	if(isset($_SESSION['message']) AND !empty($_SESSION['message'])) {
		echo $_SESSION['message'];
	} else {
		echo 'There are no errors!';
	}
	?>
</p>
<a href="index.php"><button class="error-button">Home</button></a>
</div>
<?php
	include 'footer.php';
?>