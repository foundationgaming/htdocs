<?php
require_once('includes/db_connect.php');
session_start();
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
    <div class="container">
        <form class="login" method="post" action="loginaction.php">
            <h1>Welcome! Please Login</h1>
            <p>
                <label class="infield" for="name">Name:</label>
                <input name="a" type="text" id="name">
            </p>
            <p>
                <label class="infield" for="pswd">Password:</label>
                <input name="b" type="password" id="pswd">
            </p>
            <input name="submit" class="submit" type="submit">
        </form>
    </div>
</body>
</html>