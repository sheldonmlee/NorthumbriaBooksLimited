// define pages
const URL = "pages/default.php?page="
const URL_HOME =	URL + "home.php";
const URL_ADMIN	=	URL + "admin.php";
const URL_ORDER =	URL + "order.php";

//register callbacks
document.getElementById("nav_home").onclick =	() => getBody(URL_HOME);
document.getElementById("nav_admin").onclick =	() => getBody(URL_ADMIN);
document.getElementById("nav_order").onclick =	() => getBody(URL_ORDER);

getBody(URL_HOME);

function getPage(page_name)
{
	getBody(URL+page_name);
}

function getBody(url)
{
	fetch(url).then(handleResponse);
}

// helper function to insert text content into main.
function handleResponse(response)
{
	const contentType = response.headers.get('content-type');
	if (contentType.includes("text/html")) {
		response.text()
			.then((text) => { document.getElementById("main").innerHTML = text })
			.catch(err => console.log("Something went wrong.", err))
	}
}

