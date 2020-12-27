<?php
include("includes.php");

$dbConn = getConnection($details);
$dbConn->setAttribute(pdo::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

print_r($_GET);

$bookISBN = defaultNull($_GET, "bookISBN");
$bookTitle = defaultNull($_GET, "bookTitle");
$bookYear = defaultNull($_GET, "bookYear");
$bookPrice = defaultNull($_GET, "bookPrice");
$catID = defaultNull($_GET, "catID");
$pubID = defaultNull($_GET, "pubID");

$sql = "
UPDATE NBL_books
SET bookTitle = :bookTitle, bookYear = :bookYear, bookPrice = :bookPrice, catID = :catID, pubID = :pubID
WHERE bookISBN = :bookISBN;
";

$sth = $dbConn->prepare($sql);
try {
	$sth->execute(array(
		":bookTitle" => "$bookTitle",
		":bookYear" => "$bookYear",
		":bookPrice" => $bookPrice,
		":catID" => "$catID",
		":pubID" => "$pubID",
		":bookISBN" => "$bookISBN",
	));
}
catch(Exception $e) {
	echo "<h2>Error</h2>\n<p>{$e->getMessage()}</p>";
}

$sql = "
SELECT * from NBL_books
WHERE bookISBN = :bookISBN;
";

$sth = $dbConn->prepare($sql);
$sth->execute(array("bookISBN" => $bookISBN));

$book = $sth->fetch();

echo "
<h2>Book updated:</h2>
<ul>\n
<li>ISBN: {$book["bookISBN"]}</li>
<li>Title: {$book["bookTitle"]}</li>
<li>Year: {$book["bookYear"]}</li>
<li>Price: {$book["bookPrice"]}</li>
<li>CategoryID: {$book["catID"]}</li>
<li>PublisherID: {$book["pubID"]}</li>
</ul>\n
";

$sth = null;
$dbConn = null;
?>
