<?php
require_once('php_action/db_connect.php');
session_start();
if(isset($_SESSION['userId']))
{
	header('location: http://localhost/foundationgamingstock/dashboard.php');
}
$errors = array();
if($_POST)
{
	$username = $mysqli->escape_string($_POST['username']);
	$password = $mysqli->escape_string($_POST['password']);
	if(empty($username) || empty($password))
	{
		if($username == "")
		{
			$errors[] = "Username is required";
		}
		if($password == "")
		{
			$errors[] = "Password is required";
		}
	}
	else
	{
		$sql = "SELECT * FROM users WHERE username = '$username'";
		$result = $connect->query($sql);
		if(mysqli_num_rows($result) == 1)
		{
			$password = md5($password);
			$mainsql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
			$mainresult = $connect->query($mainsql);
			if($mainresult->num_rows == 1)
			{
				$value = $mainresult->fetch_assoc();
				$user_id = $value['user_id'];
				$_SESSION['userId'] = $user_id;
				header('location: http://localhost/foundationgamingstock/dashboard.php');
			}
			else
			{
				$errors[] = "Incorrect Username or Password";
			}
		}
		else
		{
			$errors[] = "Username does not exist";
		}
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Stock Management System</title>
	<!-- bootstrap -->
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">
	<!-- bootstrap theme -->
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap-theme.min.css">
	<!-- font awesome -->
	<link rel="stylesheet" type="text/css" href="assets/font-awesome/css/fontawesome.min.css">
	<!-- custom css -->
	<link rel="stylesheet" type="text/css" href="custom/css/custom.css">
	<!-- jquery -->
	<script type="text/javascript" src="assets/jquery/jquery.min.js"></script>
	<!-- jqueryui -->
	<link rel="stylesheet" type="text/css" href="assets/jquery-ui/jquery-ui.min.css">
	<script type="text/javascript" src="assets/jquery-ui/jquery-ui.min.js"></script>
	<!-- bootstrap.js -->
	<script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
</head>
	<body>
		<div class="container">
			<div class="row vertical">
				<div class="col-md-5 col-md-offset-4">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Please Sign In</h3>
						</div>
						<div class="panel-body">
							<div class="messages">
								<?php 
								if($errors)
								{
									foreach($errors as $key => $value)
									{
										echo '<div class="alert alert-warning" role="alert">
										<i class="glyphicon glyphicon-exclamation-sign"></i>'.$value.'</div>';
									}
								}
								?>
							</div>
    						<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="loginForm">
							  <div class="form-group">
								<label for="username" class="col-sm-2 control-label">Username</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control" id="username" name="username" placeholder="Username">
								</div>
							  </div>
							  <div class="form-group">
								<label for="password" class="col-sm-2 control-label">Password</label>
								<div class="col-sm-10">
								  <input type="password" class="form-control" id="password" name="password" placeholder="Password">
								</div>
							  </div>
							  <div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
								  <div class="checkbox">
									<label>
									  <input type="checkbox"> Remember me
									</label>
								  </div>
								</div>
							  </div>
							  <div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
								  <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-log-in"></i> Sign in</button>
								</div>
							  </div>
							</form>
  						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>