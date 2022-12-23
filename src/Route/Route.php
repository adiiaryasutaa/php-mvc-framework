<?php

namespace Ceceply\Framework\Route;

use Ceceply\Framework\Application;
use Ceceply\Framework\Contract\Route\RouteContract;

class Route implements RouteContract
{
	protected Application $app;
	protected array $routes = [];

	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	public function add(string $method, string $uri, callable $concrete)
	{
		$this->routes[$method][$uri] = $concrete;
	}

	public function resolve()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		$uri = $_SERVER['REQUEST_METHOD'];

		$concrete = $this->routes[$method][$uri];

		$concrete();
	}
}