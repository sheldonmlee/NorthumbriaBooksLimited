<?php
require_once("includes.php");
require_once("details.php");

$redirect_location = ROOT."/pages/default.php?page=admin.php";

$bookISBN = defaultNull($_POST, "bookISBN");
$bookTitle = defaultNull($_POST, "bookTitle");
$bookYear = defaultNull($_POST, "bookYear");
$bookPrice = defaultNull($_POST, "bookPrice");
$catID = defaultNull($_POST, "catID");
$pubID = defaultNull($_POST, "pubID");

// redirect if any fields are empty
{
	$arr = array($bookISBN, $bookTitle, $bookYear, $bookPrice, $catID, $pubID);
	foreach($arr as $item) {
		if (empty($item)){
			echo "<h2>Please fill in all fields.</h2>\n";
			echo "<a href=\"$redirect_location\">Go back.</a>\n";
			exit;
		}
	}
}

$dbConn = getConnection($details);
$dbConn->setAttribute(pdo::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql1 = "
UPDATE NBL_books
SET bookTitle = :bookTitle, bookYear = :bookYear, bookPrice = :bookPrice, catID = :catID, pubID = :pubID
WHERE bookISBN = :bookISBN;
";

$sql2 = "
SELECT * FROM NBL_books
JOIN NBL_publisher ON NBL_publisher.pubID = NBL_books.pubID
JOIN NBL_category ON NBL_category.catID = NBL_books.catID
WHERE bookISBN = :bookISBN;
";

$book = null;

try {

	$sth = $dbConn->prepare($sql1);
	$sth->execute(array(
		":bookTitle" => $bookTitle,
		":bookYear" => $bookYear,
		":bookPrice" => $bookPrice,
		":catID" => $catID,
		":pubID" => $pubID,
		":bookISBN" => $bookISBN,
	));

	$sth = $dbConn->prepare($sql2);
	$sth->execute(array("bookISBN" => $bookISBN));
	$book = $sth->fetch();
}
catch(Exception $e) {
	echo "<h2>Error</h2>\n<p>{$e->getMessage()}</p>\n";
}

echo "
<h2>Book updated:</h2>\n
<ul>\n
<li>ISBN: {$book["bookISBN"]}</li>\n
<li>Title: {$book["bookTitle"]}</li>\n
<li>Year: {$book["bookYear"]}</li>\n
<li>Price: {$book["bookPrice"]}</li>\n
<li>Category: {$book["catDesc"]}</li>\n
<li>Publisher: {$book["pubName"]}</li>\n
</ul>\n
<a href=\"$redirect_location\">Go back.</a>\n
";

$sth = null;
$dbConn = null;

?>
