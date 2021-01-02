"use strict"

const PAGE_DIR = "pages/default.php?page=";

// add routes
const router = new Router();
router.add("/", (args) => getPage("home.php", args));
router.add("/admin", (args) => getPage("admin.php", args));
router.add("/admin/edit", (args) => getPage("editBookForm.php", args));
router.add("/order", (args) => getPage("order.php", args));

window.onload = () => router.route();
window.onhashchange = () => router.route();

document.getElementById("nav_home").onclick = () => Router.pushHistory("/");;
document.getElementById("nav_admin").onclick = () => Router.pushHistory("/admin");
document.getElementById("nav_order").onclick = () => Router.pushHistory("/order");

// Check for change in page
const mainNode = document.getElementById("main");
const config = { childList: true }

const observer = new MutationObserver(function() {
	// if orderForm exists, run js for form checking();
	if (document.getElementById("orderForm")) checkOrderForm();
});
observer.observe(mainNode, config);

getPage("home.php")

function getPage(page_name, args="")
{
	getBody(PAGE_DIR+page_name, args);
}

function getBody(url, args="")
{
	if (args != "") url +='&'+args.slice(1);
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

