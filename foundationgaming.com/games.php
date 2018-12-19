<?php
	include_once 'header.php';
?>

<section class="main-container">
		<div class="main-wrapper-games">
			<h1>Games by Foundation Gaming</h1>
			<h2>In development</h2>
			<?php
					if(isset($_SESSION['fg_id'])){
						echo '
				<div class="columns">
					<ul class="price">
						<li class="header">Download</li>
						<li class="header">TURRETZ!</li>
						<li>Demo!</li>
						<li class="grey"><a href="downloads/Turretz!.zip" class="button">For Windows!</a></li>
					</ul>
				</div>';
					} else {
						echo '				
				<p class="indev-error">
					Please login to download free demos!
				</p>
				';}
				?>
		</div>
	</section>
	
<?php
	include_once 'footer.php';
?>