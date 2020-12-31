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
