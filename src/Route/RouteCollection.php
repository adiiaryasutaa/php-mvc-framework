<?php

namespace Ceceply\Framework\Route;

use Ceceply\Framework\Route\Dto\Route;

class RouteCollection
{
	protected array $routes = [];

	public function add(Route $route)
	{
		$this->routes[] = $route;
	}

	public function getMatched(string $method, string $uri): ?Route
	{
		foreach ($this->routes as $route) {
			if ($route->method === $method && $route->uri === $uri) {
				return $route;
			}
		}

		return null;
	}
}