<!doctype html>
<html lang = "en">
	<head>
		<meta charset="utf-8">
		<title>Title</title>
		<link rel="stylesheet" href="css/stylesheet.css">
	</head>

	<body>
		<nav>
			<a id="nav_home"	href="default.php?page=home.php">HOME</a>
			<a id="nav_admin"	href="default.php?page=admin.php">ADMIN</a>
			<a id="nav_order"	href="default.php?page=order.php">ORDER</a>
			<a id="nav_credits"	href="default.php?page=credits.php">CREDITS</a>
		</nav>

		<main>
<?php
require_once("php/includes.php");
require_once("php/loginInterface.php");

$page = isset($_REQUEST["page"])? $_REQUEST["page"] : "home.php";
	
$page_location = "pages/$page";
$php_location = "php/$page";

if (file_exists($page_location)) {
	echo "<section id=\"login\">\n";
	echo "<h2>Login:</h2>\n";
	echo LoginInterface::getLogin();
	echo "</section>\n";
	echo "<section id=\"content\">\n";
	include $page_location;
	echo "</section>\n";
}
else if (file_exists($php_location)) {
	include $php_location;
}
else {
	echo "<h1>Page Not found</h1\n>";
	echo "<p>$page_location</p>\n";
	echo "<p>$php_location</p>\n";
}
?>
		</main>
	</body>
</html>
