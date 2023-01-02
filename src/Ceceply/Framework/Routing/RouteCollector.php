<?php

namespace Ceceply\Framework\Routing;

class RouteCollector
{
	/**
	 * Store routes
	 *
	 * @var Route[]
	 */
	protected array $routes = [];

	/**
	 * Add a new route
	 *
	 * @param Route $route
	 * @return void
	 */
	public function add(Route $route)
	{
		$this->routes[] = $route;
	}

	/**
	 * Find route by method and URI
	 *
	 * @param string $method
	 * @param string $uri
	 * @return Route|null
	 */
	public function get(string $method, string $uri): ?Route
	{
		foreach ($this->routes as $route) {
			if ($route->getMethod() === $method && $route->matches($uri)) {
				return $route;
			}
		}

		return null;
	}
}