<?php
include("includes.php");
const REDIRECT = "../";

// if logout is set, logout.
// if login is set, login.
if (isset($_GET["logout"])) logout();
if (isset($_GET["login"])) login();

//
// Login / logout functionality
function login()
{
	if (loggedIn()) return;
	$username = trim(defaultNull($_POST, "username"));
	$password = defaultNull($_POST, "password");

	// if fields not empty
	if (!empty($username) and !empty($password)) {
		$user = getUserDetails($username);
		$hash = $user["passwordHash"];
		$userID = $user["userID"];

		// if password not correct, show error and exit.
		if (password_verify($password, $hash)) {
			initSession();
			$_SESSION["userID"] = $userID;
			$_SESSION["username"] = $username;
		}
	}
	header("Location: ".REDIRECT);
}

function logout()
{
	initSession();
	session_unset();
	session_destroy();
	header("Location: ".REDIRECT);
}

function loggedIn()
{
	initSession();
	$logged_in = isset($_SESSION["userID"])	;
	if (!$logged_in) session_destroy();
	return $logged_in;
}

// querys database to get user information
function getUserDetails($username)
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
?>
