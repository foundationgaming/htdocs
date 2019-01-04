<?php
require_once('includes/db_connect.php');
session_start();
if(!isset($_SESSION['id']))
{
	header('location: http://localhost/jachim/login.php');
}
else
{
    $name = $_SESSION['id'];
    $user = $_SESSION['name'];
}
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
<nav class="fixed navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#"><?php echo($user);?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Reset</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Report</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>
    </ul>
  </div>
</nav>
<div class="input-group input-group-lg">
    <div class="input-group-prepend">
        <span class="input-group-text" id="inputGroup-sizing-lg">Weight</span>
    </div>
    <input type="text" class="form-control" name="weight" id="weight" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
</div>
<div class="input-group input-group-lg">
    <div class="input-group-prepend">
        <span class="input-group-text" id="inputGroup-sizing-lg date">Date</span>
    </div>
    <input type="text" class="form-control" name="date" id="date" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
</div>
<div class="container intakedata">
    <h1>Intake</h1>
    
    <select class=" dark btn btn-secondary btn-lg dropdown-toggle" name="intaketime" id="intaketime">
        <option class="dropdown-item disabled" selected disabled>Time</option>
        <div class="dropdown-divider"></div>
        <option class="dropdown-item" value="0000">Midnight</option>
        <option class="dropdown-item" value="0000">1am</option>
        <option class="dropdown-item" value="0000">2am</option>
        <option class="dropdown-item" value="0000">3am</option>
        <option class="dropdown-item" value="0000">4am</option>
        <option class="dropdown-item" value="0000">5am</option>
        <option class="dropdown-item" value="0000">6am</option>
        <option class="dropdown-item" value="0000">7am</option>
        <option class="dropdown-item" value="0000">8am</option>
        <option class="dropdown-item" value="0000">9am</option>
        <option class="dropdown-item" value="0000">10am</option>
        <option class="dropdown-item" value="0000">11am</option>
        <option class="dropdown-item" value="0000">Noon</option>
        <option class="dropdown-item" value="0000">1pm</option>
        <option class="dropdown-item" value="0000">2pm</option>
        <option class="dropdown-item" value="0000">3pm</option>
        <option class="dropdown-item" value="0000">4pm</option>
        <option class="dropdown-item" value="0000">5pm</option>
        <option class="dropdown-item" value="0000">6pm</option>
        <option class="dropdown-item" value="0000">7pm</option>
        <option class="dropdown-item" value="0000">8pm</option>
        <option class="dropdown-item" value="0000">9pm</option>
        <option class="dropdown-item" value="0000">11pm</option>
        <option class="dropdown-item" value="0000">11pm</option>
    </select>
    
    <div class="input-group input-group-lg">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-lg">JEJ</span>
        </div>
        <input type="text" class="form-control" name="jej" id="jej" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
    </div>
    
    <div class="input-group input-group-lg">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-lg">Meds</span>
        </div>
        <input type="text" class="form-control" name="meds" id="meds" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
    </div>
    
    <div class="input-group input-group-lg">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-lg">Other</span>
        </div>
        <input type="text" class="form-control" name="inputother" id="inputother" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
    </div>
    
    <div class="input-group input-group-lg">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-lg">Comments</span>
        </div>
        <textarea type="text" class="form-control" name="inputcomments" id="inputcomments" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg"></textarea>
    </div>
</div>
<div class="container outputdata">

    <h1>Output</h1>
    
    <select class=" dark btn btn-secondary btn-lg dropdown-toggle" name="intaketime" id="outputtime">
        <option class="dropdown-item disabled" selected disabled>Time</option>
        <div class="dropdown-divider"></div>
        <option class="dropdown-item" value="0000">Midnight</option>
        <option class="dropdown-item" value="0000">1am</option>
        <option class="dropdown-item" value="0000">2am</option>
        <option class="dropdown-item" value="0000">3am</option>
        <option class="dropdown-item" value="0000">4am</option>
        <option class="dropdown-item" value="0000">5am</option>
        <option class="dropdown-item" value="0000">6am</option>
        <option class="dropdown-item" value="0000">7am</option>
        <option class="dropdown-item" value="0000">8am</option>
        <option class="dropdown-item" value="0000">9am</option>
        <option class="dropdown-item" value="0000">10am</option>
        <option class="dropdown-item" value="0000">11am</option>
        <option class="dropdown-item" value="0000">Noon</option>
        <option class="dropdown-item" value="0000">1pm</option>
        <option class="dropdown-item" value="0000">2pm</option>
        <option class="dropdown-item" value="0000">3pm</option>
        <option class="dropdown-item" value="0000">4pm</option>
        <option class="dropdown-item" value="0000">5pm</option>
        <option class="dropdown-item" value="0000">6pm</option>
        <option class="dropdown-item" value="0000">7pm</option>
        <option class="dropdown-item" value="0000">8pm</option>
        <option class="dropdown-item" value="0000">9pm</option>
        <option class="dropdown-item" value="0000">11pm</option>
        <option class="dropdown-item" value="0000">11pm</option>
    </select>
    
    <div class="input-group input-group-lg">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-lg">Urine</span>
        </div>
        <input type="text" class="form-control" name="urine" id="urine" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
    </div>
    
    <div class="input-group input-group-lg">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-lg">Toilet</span>
        </div>
        <input type="text" class="form-control" name="toilet" id="toilet" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
    </div>
    
    <div class="input-group input-group-lg">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-lg">Stoma</span>
        </div>
        <input type="text" class="form-control" name="stoma" id="stoma" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
    </div>
    
    <div class="input-group input-group-lg">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-lg">Aspirate</span>
        </div>
        <input type="text" class="form-control" name="aspirate" id="aspirate" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
    </div>
    
    <div class="input-group input-group-lg">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-lg">Drain</span>
        </div>
        <input type="text" class="form-control" name="drain" id="drain" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
    </div>
    
    <div class="input-group input-group-lg">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-lg">Other</span>
        </div>
        <input type="text" class="form-control" name="outputother" id="outputother" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
    </div>
    
    <div class="input-group input-group-lg">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-lg">Comments</span>
        </div>
        <textarea type="text" class="form-control" name="outputcomments" id="outputcomments" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg"></textarea>
    </div>
</div>
</div>
</body>
</html>