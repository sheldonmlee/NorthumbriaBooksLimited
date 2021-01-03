<?php
include("includes.php");

// if logout is set, logout.
// if login is set, login.
if (isset($_GET["logout"])) Session::logout();
if (isset($_GET["login"])) Session::login();

// session management
class Session 
{ 
	//
	// Login / logout functionality
	//

	public static function login()
	{
		if (self::loggedIn()) return;
		$username = trim(defaultNull($_POST, "username"));
		$password = defaultNull($_POST, "password");

		// if fields not empty
		if (!empty($username) and !empty($password)) {
			$user = self::getUserDetails($username);
			$hash = $user["passwordHash"];
			$userID = $user["userID"];

			// if password not correct, show error and exit.
			if (password_verify($password, $hash)) {
				initSession();
				$_SESSION["userID"] = $userID;
				$_SESSION["username"] = $username;
			}
		}
		//self::getRedirect();
		header("Location: ".self::getRedirect());
	}

	public static function logout()
	{
		initSession();
		session_unset();
		session_destroy();
		//self::getRedirect();
		header("Location: ".self::getRedirect());
	}

	// Check session.
	public static function loggedIn()
	{
		initSession();
		$logged_in = isset($_SESSION["userID"])	;
		if (!$logged_in) session_destroy();
		return $logged_in;
	}

	//
	// Helper functions
	//

	// Gets location relative this file.
	private static function getRedirect() {
		print_r($_GET);
		$page = defaultString($_GET, "page", "home.php");
		return "../default.php?page=$page";
	}

	// querys database to get user information
	private static function getUserDetails($username)
	{
		require("details.php");
		$dbConn = getConnection($details);

		$sql = "
		SELECT * FROM NBL_users
		WHERE username = :username;
		";

		$sth = $dbConn->prepare($sql);
		$sth->execute(array(
			":username" => $username
		));

		// if user not found, show error and exit.
		if($sth->rowCount() == 0) return false;

		return $sth->fetch();
	}
}
?>

