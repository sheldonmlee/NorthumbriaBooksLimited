<?php
require_once("includes.php");

function getLoginForm()
{
	$logged_in = false;
	$form = array(
		"method" =>	Method::POST,
		"action" => "php/login.php",	
		"inputs" => array(
			array("type" => Input::TEXT, "label" => "username :", "name" => "username"),
			array("type" => Input::TEXT, "label" => "password :", "name" => "password"),
			array("type" => Input::SUBMIT)
		)
	);
	return generateForm($form);
}
?>
