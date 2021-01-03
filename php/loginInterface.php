<?php
require_once("includes.php");
require_once("login.php");

// Path relative to where form will be displayed, rather than this file.
const LOGIN_ACTION = "php/login.php?login";
const LOGOUT_ACTION = "php/login.php?logout";

class loginInterface
{
	// If function logged in, display logout, else display logout form.
	public static function getLogin()
	{
		if (Session::loggedIn()) return self::getLogout();
		else return self::getLoginForm();
	}

	// 
	// Helper functions
	//

	private static function getPageArg()
	{
		return "&page=".defaultString($_GET, "page", "home.php");
	}

	private static function getLoginForm()
	{
		$form = array(
			"method" =>	Method::POST,
			"action" => LOGIN_ACTION.self::getPageArg(),	
			"inputs" => array(
				array("type" => Input::TEXT, "label" => "username :", "name" => "username"),
				array("type" => Input::PASSWORD, "label" => "password :", "name" => "password"),
				array("type" => Input::SUBMIT)
			)
		);
		return generateForm($form);
	}

	private static function getLogout()
	{
		initSession();	
		$str = 
			"<p>Logged in as {$_SESSION["username"]}<br>
			<a href=\"".LOGOUT_ACTION.self::getPageArg()."\">Logout</a></p>";
		return $str;
	}
}
?>
