<?php
require_once("../lib/phpUtils/utils.php");
$page = isset($_REQUEST["page"])? $_REQUEST["page"] : "home";

switch($page) {
case "home":
	getHome();
	break;
case "admin":
	getAdmin();
	break;
}

function getHome()
{
	getLoginForm();
	echo "<p>Home page.</p>";
}

function getAdmin()
{
	getLoginForm();
	echo "<p>Admin page.</p>";
}

function getLoginForm()
{
	$form = array(
		"method" =>	Method::POST,
		"action" => "login.php",	
		"inputs" => array(
			array("type" => Input::TEXT, "label" => "username :", "name" => "username"),
			array("type" => Input::TEXT, "label" => "password :", "name" => "password"),
			array("type" => Input::SUBMIT)
		)
	);
	echo generateForm($form);
}


?>
