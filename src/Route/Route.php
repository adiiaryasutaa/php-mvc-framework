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
		$uri = $_SERVER['REQUEST_URI'];

		$concrete = $this->routes[$method][$uri];

		if (!$concrete) {

		}

		if (is_callable($concrete)) {
			$concrete();
		}

		if (is_array($concrete)) {
			$controller = $concrete[0];
			$method = $concrete[1];

			call_user_func([$controller, $method]);
		}

	}
}