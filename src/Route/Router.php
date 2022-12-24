<?php

namespace Ceceply\Framework\Route;

use Ceceply\Framework\Application;
use Ceceply\Framework\Contract\Route\RouterContract;
use Ceceply\Framework\Route\Dto\Route;
use Ceceply\Framework\Route\Exception\RouteNotFoundException;

class Router implements RouterContract
{
	protected Application $app;
	protected RouteCollection $collection;
	protected RouteActionResolver $resolver;

	public function __construct(Application $app)
	{
		$this->app = $app;
		$this->collection = new RouteCollection();
		$this->resolver = new RouteActionResolver();
	}

	public function add(string $method, string $uri, callable|array $action)
	{
		$route = new Route($method, $uri, $action);

		$this->collection->add($route);

		return $route;
	}

	/**
	 * @throws RouteNotFoundException
	 */
	public function resolve()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		$uri = $_SERVER['REQUEST_URI'];

		$route = $this->collection->getMatched($method, $uri);

		if (is_null($route)) {
			throw new RouteNotFoundException($method, $uri);
		}

		return $this->resolver->resolve($route->action);
	}
}