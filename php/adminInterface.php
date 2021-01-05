<?php
require_once("includes.php");
#
# Encapsulates admin interface
#
class AdminInterface
{
	// Get form to edit single book;
	public static function getEditBookForm()
	{
		require("details.php");
		$bookISBN = defaultNull($_GET, "bookISBN");

		$dbConn = getConnection($details);

		$results = $dbConn->query("
		SELECT bookISBN, bookTitle, bookYear, bookPrice, catID, pubID FROM NBL_books
		WHERE bookISBN = $bookISBN;
		");

		if (!$results) {
			echo "<h2>No Results</h2>\n";
			exit;
		}

		$book = $results->fetch();

		$form= array(
			"method" => Method::POST,
			"action" => "default.php?page=editBook.php",
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
		return generateForm($form);
	}

	// Get a list of all bokos to edit.
	public static function getEditBooksList()
	{
		require("details.php");
		$dbConn = getConnection($details);

		$results = $dbConn->query("SELECT bookISBN, bookTitle FROM NBL_books");

		$output = "<div id=\"editBooks\">\n";
		foreach($results as $row) {
			$output .= "<li>
				<a href=\"default.php?page=edit.php&bookISBN={$row["bookISBN"]}\">Edit</a>
		{$row["bookTitle"]}
		</li>\n";
		}
		$output .= "</li>\n";
		$output .= "</div>\n";

		$dbConn = null;
		$results = null;
		return $output;
	}
}
?>
