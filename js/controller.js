//import {Router} from "./router.js";

"use strict"

// define pages
const URL = "pages/default.php?page=";
const URL_HOME =	URL + "home.php";
const URL_ADMIN	=	URL + "admin.php";
const URL_ORDER =	URL + "order.php";

const router = new Router();
router.add("/", () => getPage("home.php"));
router.add("/admin", () => getPage("admin.php"));
//router.add("/admin/edit" () => getPage("editbooksForm.php"));

window.onload = () => router.route();
window.onhashchange = () => router.route();

document.getElementById("nav_home").onclick = () => Router.pushHistory("/");;
document.getElementById("nav_admin").onclick = () => Router.pushHistory("/admin");

getPage("home.php")

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

