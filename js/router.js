"use strict"
// 
// A basic Hash Router
//
// When adding paths, omit the hash as it is added automatically.
// The same applies for pushHistory.
class Router
{
	constructor()
	{
		this.routes = []
	}

	// Add route with path and callback for page.
	add(_path, _callback) {
		this.routes.push({
			path: _path,
			callback: _callback
		});
	}

	// Tries to find if a route exists, otherwise it returns first route.
	// If no route has ben added, it retuns null
	getRoute(path)
	{
		if (this.routes.length == 0) return null;
		for (const route of this.routes) {
			if (path == route.path) return route;
		}
		return this.routes[0];
	}

	// Gets the hash route from url.
	route()
	{
		// remove hashtag in the beginning
		let path = window.location.hash.slice(1);
		
		let args = "";

		// look for start of arguments and exclude from path, assigning to args
		let arg_pos = path.search("\\?");
		if (arg_pos != -1) {
			args = path.slice(arg_pos, path.length);
			path = path.slice(0, arg_pos);
		}
	
		// TODO get default instead if null.
		const route = this.getRoute(path);
		if (route == null) return;
		route.callback(args);
	}

	// Change the window location, and trigger window.onhashchange event (unlike window.pushState()).
	static pushHistory(path)
	{
		window.location = "#"+path;
	}
}

