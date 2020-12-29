<?php
require_once("includes.php");
require_once("login.php");


function getLogin()
{
	if (loggedIn()) return getLogout();
	else return getLoginForm();
}

function getLoginForm()
{
	$form = array(
		"method" =>	Method::POST,
		"action" => "php/login.php?login",	
		"inputs" => array(
			array("type" => Input::TEXT, "label" => "username :", "name" => "username"),
			array("type" => Input::PASSWORD, "label" => "password :", "name" => "password"),
			array("type" => Input::SUBMIT)
		)
	);
	return generateForm($form);
}

function getLogout()
{
	initSession();	
	$str = "<p>Logged in as {$_SESSION["username"]}<br><a href=\"php/login.php?logout\">Logout</a></p>";
	return $str;
}
?>
