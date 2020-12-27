<?php
require_once("../php/includes.php");

print_r($_GET);
$bookISBN = defaultNull($_GET, "bookISBN");

$dbConn = getConnection($details);

$results = $dbConn->query("
SELECT bookISBN, bookTitle, bookYear, bookPrice, catID, pubID FROM NBL_books
WHERE bookISBN = $bookISBN;
");

$book = $results->fetch();

$form= array(
	"method" => Method::GET,
	"action" => "php/editBook.php",
	"inputs" => array (
		array("type" => Input::TEXT, "label" => "ISBN:", "name" => "bookISBN", "value" => $book["bookISBN"], "readonly"),
		array("type" => Input::TEXT, "label" => "Title", "name" => "bookTitle", "value" => $book["bookTitle"]),
		array("type" => Input::TEXT, "label" => "Year:", "name" => "bookYear", "value" => $book["bookYear"]),
		array("type" => Input::TEXT, "label" => "Price:", "name" => "bookPrice", "value" => $book["bookPrice"]),
		array(
			"type" => Select::FROM_TABLE,
			"connection" => $dbConn,
			"label" => "Category:",
			"table" => "NBL_category",
			"id_field" => "catID",
			"display_field" => "catDesc",
			"default_id" => $book["catID"]
		),
		array(
			"type" => Select::FROM_TABLE,
			"connection" => $dbConn,
			"label" => "Publisher:",
			"table" => "NBL_publisher",
			"id_field" => "pubID",
			"display_field" => "pubName",
			"default_id" => $book["pubID"]
		),
		array("type" => Input::SUBMIT)
	)
);
echo generateForm($form);
?>
