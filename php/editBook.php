<?php
require_once("includes.php");
require_once("details.php");

$redirect_location = "../index.html";

$bookISBN = defaultNull($_GET, "bookISBN");
$bookTitle = defaultNull($_GET, "bookTitle");
$bookYear = defaultNull($_GET, "bookYear");
$bookPrice = defaultNull($_GET, "bookPrice");
$catID = defaultNull($_GET, "catID");
$pubID = defaultNull($_GET, "pubID");

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

$sql = "
UPDATE NBL_books
SET bookTitle = :bookTitle, bookYear = :bookYear, bookPrice = :bookPrice, catID = :catID, pubID = :pubID
WHERE bookISBN = :bookISBN;
";

$sth = $dbConn->prepare($sql);
try {
	$sth->execute(array(
		":bookTitle" => $bookTitle,
		":bookYear" => $bookYear,
		":bookPrice" => $bookPrice,
		":catID" => $catID,
		":pubID" => $pubID,
		":bookISBN" => $bookISBN,
	));
}
catch(Exception $e) {
	echo "<h2>Error</h2>\n<p>{$e->getMessage()}</p>\n";
}

$sql = "
SELECT * from NBL_books
WHERE bookISBN = :bookISBN;
";

$sth = $dbConn->prepare($sql);
$sth->execute(array("bookISBN" => $bookISBN));

$book = $sth->fetch();

echo "
<h2>Book updated:</h2>\n
<ul>\n
<li>ISBN: {$book["bookISBN"]}</li>\n
<li>Title: {$book["bookTitle"]}</li>\n
<li>Year: {$book["bookYear"]}</li>\n
<li>Price: {$book["bookPrice"]}</li>\n
<li>CategoryID: {$book["catID"]}</li>\n
<li>PublisherID: {$book["pubID"]}</li>\n
</ul>\n
<a href=\"$redirect_location\">Go back.</a>\n
";

$sth = null;
$dbConn = null;

?>
