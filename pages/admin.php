<?php
require_once("../lib/phpUtils/utils.php");
require_once("details.php");
$dbConn = getConnection($details);

$results = $dbConn->query("
SELECT bookISBN, bookTitle FROM NBL_books
");

echo "<div id=\"editBooks\">\n";
echo "<li>\n";
foreach($results as $row) {
	echo "<li>
		<button onclick=\"getBody('pages/editBookForm.php?bookISBN={$row["bookISBN"]}')\">Edit</button>
		{$row["bookTitle"]}
		</li>\n";
}
echo "</li>\n";
echo "</div>\n";

$dbConn = null;
$results = null;
?>
