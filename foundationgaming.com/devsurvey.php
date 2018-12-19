<?php
	include_once 'header.php';
?>

<section class="main-container">
		<div class="main-wrapper">
			<h1 class="survey-h1">Game Development Survey</h1>
			<div class="">
				<p><b>Thank you</b> for agreeing to complete this survey. Your answers in this survey will go towards the development of future games.
					<form class="survey-form" action="includes/devsurvey.inc.php" method="POST">
						<p class="survey-q">What is your favorite type of computer game?</p>
						<div class="survey-a">
							<input type="radio" name="type" value="rpg">RPG<div class="tooltip"><img src="img/questionmark.png" alt="Example:" style="width:12px;height:12px;">
							<span class="tooltiptext">Role-Playing Game</span>
							</div><br>
							<input type="radio" name="type" value="moba">MOBA<div class="tooltip"><img src="img/questionmark.png" alt="Example:" style="width:12px;height:12px;">
							<span class="tooltiptext">Multiplayer Online Battle Arena</span>
							</div><br>
							<input type="radio" name="type" value="fps">FPS<div class="tooltip"><img src="img/questionmark.png" alt="Example:" style="width:12px;height:12px;">
							<span class="tooltiptext">First Person Shooter</span>
							</div><br>
							<input type="radio" name="type" value="rts">RTS<div class="tooltip"><img src="img/questionmark.png" alt="Example:" style="width:12px;height:12px;">
							<span class="tooltiptext">Real Time Strategy</span>
							</div><br>
							<input type="radio" name="type" value="iother">Other:<br>
							<input type="text" name="typeinput" placeholder="Other"><br>
							<br>
						</div>	
							
						<p class="survey-q">What is your preferred genre in video games?</p>
						<div class="survey-a">
							<input type="radio" name="genre" value="fantasy">Fantasy<div class="tooltip"><img src="img/questionmark.png" alt="Example:" style="width:12px;height:12px;">
							<span class="tooltiptext">Example: Skyrim</span>
							</div><br>
							<input type="radio" name="genre" value="modern">
							Modern
							<div class="tooltip"><img src="img/questionmark.png" alt="Example:" style="width:12px;height:12px;">
							<span class="tooltiptext">Example: Grand Theft Auto</span>
							</div><br>
							<input type="radio" name="genre" value="science_fiction">Sci-Fi<div class="tooltip"><img src="img/questionmark.png" alt="Example:" style="width:12px;height:12px;">
							<span class="tooltiptext">Example: Space Marine: Warhammer 40000</span>
							</div><br>
							<input type="radio" name="genre" value="post_apoc">Post Apocalyptic<div class="tooltip"><img src="img/questionmark.png" alt="Example:" style="width:12px;height:12px;">
							<span class="tooltiptext">Example: Fallout</span>
							</div><br>
							<input type="radio" name="genre" value="dystopian">Dystopian<div class="tooltip"><img src="img/questionmark.png" alt="Example:" style="width:12px;height:12px;">
							<span class="tooltiptext">Example: Shadowrun</span>
							</div><br>
							<input type="radio" name="genreinput" value="gother">Other:<br>
							<input type="text" name="typeinput" placeholder="Other"><br>
						</div>
						<br>
						<p class="survey-q">What are you prepared to pay for good quality video games?</p>
						<div class="survey-a">
							<input type="radio" name="price" value="2029">$20-$29<br>
							<input type="radio" name="price" value="3039">$30-$39<br>
							<input type="radio" name="price" value="4049">$40-$49<br>
							<input type="radio" name="price" value="5059">$50-$59<br>
							<input type="radio" name="price" value="6069">$60-$69<br>
							<input type="radio" name="price" value="7079">$70-$79<br>
							<input type="radio" name="price" value="8089">$80-$89<br>
							<input type="radio" name="price" value="9099">$90-$99<br>
							<input type="radio" name="priceinput" value="gother">Other:<br>
							<input type="text" name="typeprice" placeholder="Other"><br>
						</div>
						<br>
						<p class="survey-q">What is your age group?</p>
						<div class="survey-a">
							<input type="radio" name="age" value="u18">Under 18<br>
							<input type="radio" name="age" value="1824">18-24<br>
							<input type="radio" name="age" value="2531">25-31<br>
							<input type="radio" name="age" value="3240">32-40<br>
							<input type="radio" name="age" value="o40">Over 40<br>
						</div>
						<br>
						<p class="survey-q">Would you be happy to complete another survey regarding your answers?</p>
						<div class="survey-a">
							<input type="radio" class="thing" name="moresurvey" value="yes">Yes<br>
							<input type="text" name="moresurveyemail" placeholder="email"><br>
							<input type="radio" name="moresurvey" value="no">No<br>
						<br>
						<button type="submit" name="submit">Submit</button>
					</form>
			</div>
		</div>
	</section>
	
<?php
	include_once 'footer.php';
?>