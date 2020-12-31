<?php
require_once("login.php");

function getEditBooksList()
{
	require("details.php");
	if (!loggedIn()) return;
	$dbConn = getConnection($details);

	$results = $dbConn->query("SELECT bookISBN, bookTitle FROM NBL_books");

	$output = "<div id=\"editBooks\">\n";
	$output .= "<li>\n";
	foreach($results as $row) {
		$output .= "<li>
			<button onclick=\"Router.pushHistory('/admin/edit?bookISBN={$row["bookISBN"]}')\">Edit</button>
			{$row["bookTitle"]}
			</li>\n";
	}
	$output .= "</li>\n";
	$output .= "</div>\n";

	$dbConn = null;
	$results = null;
	return $output;
}
?>
