<?php
include ("inc/header.inc.php");
if (!isset($_SESSION['id'])) {
	header("location: index.php");
}
else
{
	echo "About gamersUnited";
}
?>