<!doctype html>
<html lang = "en">
	<head>
		<meta charset="utf-8">
		<title>Title</title>
		<link rel="stylesheet" href="../css/stylesheet.css">
	</head>

	<body>
		<nav>
			<a id="nav_home"  href="default.php?page=home.php">home</a>
			<a id="nav_admin" href="default.php?page=admin.php">admin</a>
			<a id="nav_order" href="default.php?page=order.php">order</a>
		</nav>

<?php
require_once("../php/includes.php");
require_once("../php/loginForm.php");

$page = isset($_REQUEST["page"])? $_REQUEST["page"] : "home.php";
	
$page_location = "../pages/$page";

if (file_exists($page_location)) {
	echo getLogin();
	include $page_location;
}
else {
	echo "<h1>Page Not found</h1>";
}
?>
	</body>
</html>
