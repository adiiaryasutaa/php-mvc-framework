<?php

namespace Ceceply\Framework\Route;

use Ceceply\Framework\Route\Dto\Route;

class RouteCollection
{
	/**
	 * @var Route[]
	 */
	protected array $routes = [];

	public function add(Route $route)
	{
		$this->routes[] = $route;
	}

	public function getMatched(string $method, string $uri): ?Route
	{
		foreach ($this->routes[$method] as $route) {
			if ($route->isMatched($uri)) {
				return $route;
			}
		}

		return null;
	}

	/**
	 * @return array
	 */
	public function getRoutes(): array
	{
		return $this->routes;
	}
}