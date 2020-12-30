"use strict"
// 
// A basic Hash Router
//
class Router
{
	constructor()
	{
		this.routes = []
	}

	add(_path, _callback) {
		this.routes.push({
			path: _path,
			callback: _callback
		});
	}

	getRoute(path)
	{
		for (const route of this.routes) {
			if (path == route.path) return route;
		}
		return null;
	}

	route()
	{
		// remove hash
		const path = window.location.hash.slice(1);

		// TODO get default instead if null.
		const route = this.getRoute(path);
		if (route == null) return;
		route.callback();
	}

	static pushHistory(path)
	{
		window.location = "#"+path;
	}
}

