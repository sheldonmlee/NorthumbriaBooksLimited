<h1>Edit a book:</h1>
<?php
require_once("php/adminInterface.php");
require_once("php/login.php");
if (Session::loggedIn()){ 
	echo AdminInterface::getEditBooksList();
}
else {
	echo "<p>Please login.</p>\n";
}
?>
