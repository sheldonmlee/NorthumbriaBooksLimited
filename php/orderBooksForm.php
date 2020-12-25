<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Order Books</title>
</head>
<body>
<h1>Order Books</h1>

<form id="orderForm" action="javascript:alert('form submitted');" method="get">
	<section id="orderBooks">
		<h2>Select Books</h2>
<?php
/* DO NOT ALTER the code in this php block.
It dynamically generates the html required to display one checkbox for each of the records currently held in the NBL_books database table. The user can select one or more records that they are interested in ordering by clicking the checkboxes.Use the browser to look at the structure of the html generated by the php code. */

try {
	// include the file with the function for the database connection
	require_once('includes.php');
	// get database connection
	$dbConn = getConnection($details);
	$sqlBooks = 'SELECT bookISBN, bookTitle, bookYear, catDesc, pubName, bookPrice FROM NBL_books b INNER JOIN NBL_category c ON b.catID = c.catID INNER JOIN NBL_publisher p ON b.pubID = p.pubID ORDER BY bookTitle';

	// execute the query
	$rsBooks = $dbConn->query($sqlBooks);

	while ($book = $rsBooks->fetchObject()) {
		$bookTitle = $book->bookTitle;
		echo "\t<div class='item'>
				<span class='bookTitle'>".filter_var($bookTitle, FILTER_SANITIZE_SPECIAL_CHARS)."</span>
				<span class='bookYear'>{$book->bookYear}</span>
	            <span class='catDesc'>{$book->catDesc}</span>
	         	<span class='pubName'>{$book->pubName}</span>
	            <span class='bookPrice'>{$book->bookPrice}</span>
	            <span class='chosen'><input type='checkbox' name='book[]' value='{$book->bookISBN}' data-price='{$book->bookPrice}'></span>
	      		</div>\n";
	}
}
catch (Exception $e) {
	throw new Exception("Problem " . $e->getMessage(), 0, $e);
}
?>
	</section>
	<section id="collection">
		<h2>Collection method</h2>
		<p>Please select whether you want your chosen book(s) to be delivered to your home address (a charge applies for this) or whether you want to collect them yourself.</p>
		<p>
		Home address - &pound;5.99 <input type="radio" name="deliveryType" value="home" data-price="5.99" checked>&nbsp; | &nbsp;
		Collect from shop - no charge <input type="radio" name="deliveryType" value="shop" data-price="0">
		</p>
	</section>
	<section id="checkCost">
		<h2>Total cost</h2>
		Total <input type="text" name="total" size="10" readonly>
	</section>
	<section id="placeOrder">
		<h2>Place Order</h2>
		<h3>Your details</h3>
		Customer Type
		<select name="customerType">
			<option value="">Customer Type?</option>
			<option value="ret">Customer</option>
			<option value="trd">Trade</option>
		</select>
		<div id="retCustDetails" class="custDetails">
			Forename <input type="text" name="forename">
			Surname <input type="text" name="surname">
		</div>
		<div id="tradeCustDetails" class="custDetails" style="visibility:hidden">
			Company Name <input type="text" name="companyName">
		</div>
		<p style="color: #FF0000; font-weight: bold;" id='termsText'>I have read and agree to the terms and conditions
		<input type="checkbox" name="termsChkbx"></p>
		<p><input type="submit" name="submit" value="Book now!" disabled></p>
	</section>
</form>	
<!-- Here you need to add Javascript or a link to a script (.js file) to process the form as required for the assignment -->
</body>
</html>
