"use strict";

const aside = true;
getOffer();
getOffer(aside);
setInterval(getOffer, 5000);

function getOffer(useJSON = false)
{
	let url = "php/getOffers.php";
	if (useJSON) url += "?useJSON";
	fetch(url).then(handleResponse);
}

function handleResponse(response)
{
	const contentType = response.headers.get('content-type');
	if (contentType.includes("text/html")) {
		response.text()
			.then(insertHTML)
			.catch(err => console.log("Something went wrong.", err));
	}
	else if (contentType.includes("application/json")) {
		response.json()
			.then(insertJSON)
			.catch(err => console.log("Something went wrong.", err));
	}
}

function insertHTML(text)
{
	document.getElementById("offers").innerHTML = text;
}

function insertJSON(json)
{
	const text = "&quot;"+json.bookTitle+"&quot;<br><span class=\"category\">Category: "+json.catDesc+"</span><br><span class=\"price\">Price: "+json.bookPrice+"<span>";
	document.getElementById("aside").innerHTML = text;
}
