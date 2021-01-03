<?php
require_once("php/adminInterface.php");
require_once("php/login.php");
if (Session::loggedIn()){ 
	echo AdminInterface::getEditBookForm();
}
else {
	echo "<p>Please login.</p>\n";
}
?>
