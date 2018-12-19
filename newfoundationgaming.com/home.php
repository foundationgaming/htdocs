<?php 
include_once ("inc/header.inc.php");
echo $_SESSION['username'];
if (!isset($_SESSION['id'])) {
	header("location: index.php");
} else {
	header("location: ".$_SESSION['username']);
}
?>