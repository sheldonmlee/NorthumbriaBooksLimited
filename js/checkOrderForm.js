"use strict";
//
// Get sections
//
const orderBooks = document.getElementById("orderBooks");
const collection = document.getElementById("collection");
const checkCost = document.getElementById("checkCost");
const placeOrder = document.getElementById("placeOrder");

//
// Get inputs and register callbacks.
//

// The inputs below here affect and update the price.
// Select books
const book_checkboxes = orderBooks.querySelectorAll(".item > .chosen > input[type='checkbox']");

for (let input of book_checkboxes) {
	input.onchange = updatePrice;
}

// Collection
const collection_radio_buttons = collection.querySelectorAll("input[type='radio']");

for (let input of collection_radio_buttons) {
	input.onchange = updatePrice;
}

// All the inputs below here determine, and update the submit button state.
// Place Order
const select = placeOrder.querySelector("select");
const text_inputs = placeOrder.querySelectorAll("input[type=text]");
const text_inputs_customer = placeOrder.querySelectorAll("#retCustDetails > input[type=text]");
const text_inputs_trade = placeOrder.querySelectorAll("#tradeCustDetails > input[type=text]")

// Select
// Updates visibility of the #tradeCustDetails section and submit button on value change.
select.onchange = () => {
	const trade_div = document.getElementById("tradeCustDetails");
	if (select.value == "ret") {
		trade_div.style.visibility = "hidden";
	}
	else if(select.value == "trd") {
		trade_div.style.visibility = "visible";
	}
	updateSubmitButton();
};

// Text inputs
// Updates the submit button on input change.
text_inputs.forEach((input) => {
	input.oninput = updateSubmitButton;
});

// Terms and conditions
// Updates termsText styling on value change and submit button.
const submitButton = placeOrder.querySelector("input[type='submit']");
const checkbox = placeOrder.querySelector("input[type='checkbox']");

checkbox.onchange = () => {
	const element = document.getElementById("termsText");
	if (checkbox.checked) {
		element.style.color = "black";
		element.style.fontWeight = "normal";
	} 
	else {
		element.style.color = "red";
		element.style.fontWeight = "bold";
	}
	updateSubmitButton()
}

//
// Functions
//

// Updates total value in Total cost box.
function updatePrice()
{
	const input_total = checkCost.querySelector("input[name='total']");
	let total = 0;
	// sum book prices.
	for (let input of book_checkboxes) {
		total += parseFloat(input.getAttribute("data-price")) * input.checked;
	}
	// sum collection method price.
	for (let input of collection_radio_buttons) {
		total += parseFloat(input.getAttribute("data-price")) * input.checked;
	}
	// round to 2 d.p.
	total = Math.round(total*100)/100;
	input_total.value = total;
}


// Checks that all the text inputs aren't empty.
function isValidText()
{
	let arr;
	if (select.value == "ret") arr = text_inputs_customer;
	else if (select.value == "trd") arr = text_inputs;
	for (let input of arr){
		if (!input.value) {
			return false;
		}
	}
	return true;
}

// Sets button state to disabled if either select, text inputs have not been entered,
// or the terms and conditions have not been ticked.
function updateSubmitButton()
{
	submitButton.disabled = !(select.value && isValidText() && checkbox.checked)
}
	
