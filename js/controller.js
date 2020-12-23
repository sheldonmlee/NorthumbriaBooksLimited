window.onload = function() {

	const URL = "php/default.php";
	const URL_HOME = URL + "?page=home";
	const URL_ADMIN = URL + "?page=admin";

	// register callbacks
	document.getElementById("nav_home").onclick = loadHome;
	document.getElementById("nav_admin").onclick = loadAdmin;

	loadHome();
	
	function loadHome()
	{
		fetch(URL_HOME).then(handleResponse)
		console.log("home");
	}

	function loadAdmin()
	{
		fetch(URL_ADMIN).then(handleResponse)
		console.log("admin");
	}

	function handleResponse(response)
	{
		const contentType = response.headers.get('content-type');
		if (contentType.includes("text/html")) {
			response.text().then((text) => { document.getElementById("main").innerHTML = text })
		}
	}

}
