<?php

	include('includes/dbh.inc.php');

	$type = $_POST["type"];
	$typeinput = $_POST["typeinput"];
	$genre = $_POST["genre"];
	$genreinput = $_POST["genreinput"];
	$price = $_POST["price"];
	$priceinput = $_POST["priceinput"];
	$age = $_POST["age"];
	$ageinput = $_POST["ageinput"];
	$moresurvey = $_POST["moresurvey"];
	$moresurveyemail = $_POST["moresurveyemail"];

	$sql = "INSERT INTO devsurvey (type, tother, genre, gother, price, pother, age, aother, moresurvey, moresurveyemail) VALUES ('$type', '$typeinput', '$genre', '$genreinput', '$price', '$priceinput', '$age', '$ageinput', '$moresurvey', '$moresurveyemail');";

	mysqli_query($conn, $sql);
	header("Location: ../surveythanks.php?devsurvey=thankyou");
?>