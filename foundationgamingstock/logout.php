<?php
require_once'php_action/core.php';
session_unset();
session_destroy();
header('location: http://localhost/foundationgamingstock/index.php');
?>