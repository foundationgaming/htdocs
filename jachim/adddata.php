<?php
require_once('includes/db_connect.php');
session_start();

$weight = $_POST['weight'];
$date = $_POST['date'];
$time = $_POST['time'];
$timeposted = date("H:i:s");
$food = $_POST['food'];
$jej = $_POST['jej'];
$meds = $_POST['meds'];
$inputother = $_POST['inputother'];
$inputcomments = $_POST['inputcomments'];
$urine = $_POST['urine'];
$toilet = $_POST['toilet'];
$stoma = $_POST['stoma'];
$aspirate = $_POST['aspirate'];
$drain = $_POST['drain'];
$outputother = $_POST['outputother'];
$outputcomments = $_POST['outputcomments'];

$sql = "INSERT INTO `fluid_balance` (`date`, `weight`, `time`, `timeposted`, `jej`, `meds`, `intakeother`, `intakecomments`, `urine`, `toilet`, `stoma`, `aspirate`, `drain`, `outputother`, `outputcomments`) VALUES 
                                    ('$date', '$weight', '$time', '$timeposted', '$jej', '$meds', '$inputother', '$inputcomments', '$urine', '$toilet', '$stoma', '$aspirate', '$drain', '$outputother', '$outputcomments');";

	mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- STYLESHEET -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <!-- JS -->
    <script src="js/main.js"></script>
    <!-- JQUERY -->
    <script src="js/jquery.min.js"></script>
    
    <title>Fluid Balance Record</title>
</head>
<body>
    <div class="container return">
        <div class="data">
            <h1>Data Added</h1>
            <a href="index.php">RETURN</a>
        </div>
    </div>
</body>
</html>