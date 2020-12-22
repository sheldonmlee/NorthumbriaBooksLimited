<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Title</title>
		<link rel="stylesheet" href="">
	</head>

	<body>
		<h1>Oof</h1>
	</body>
<?php

$page = isset($_REQUEST["page"])? $_REQUEST["page"] : $home 

require_once("../lib/phpUtils/utils.php");
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
?>
</html>
