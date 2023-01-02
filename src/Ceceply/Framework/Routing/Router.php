<?php

namespace Ceceply\Framework\Routing;

use Ceceply\Framework\Application;
use Ceceply\Framework\Contract\Route\RouterContract;
use Ceceply\Framework\Request\Request;
use Ceceply\Framework\Routing\Exception\ParameterHasSameName;
use Ceceply\Framework\Routing\Exception\RouteNotFoundException;

class Router implements RouterContract
{
	/**
	 * The application
	 *
	 * @var Application
	 */
	protected Application $app;

	/**
	 * The route collector
	 *
	 * @var RouteCollector
	 */
	protected RouteCollector $collection;

	/**
	 * The route action resolver
	 *
	 * @var RouteActionResolver
	 */
	protected RouteActionResolver $actionResolver;

	/**
	 * The current request
	 *
	 * @var Request
	 */
	protected Request $request;

	/**
	 * Router constructor
	 *
	 * @param Application $app
	 * @param Request $request
	 */
	public function __construct(Application $app, Request $request)
	{
		$this->app = $app;
		$this->collection = new RouteCollector();
		$this->actionResolver = new RouteActionResolver();
		$this->request = $request;
	}

	/**
	 * Add new route
	 *
	 * @param string $method
	 * @param string $uri
	 * @param callable|array $action
	 * @return Route
	 * @throws ParameterHasSameName
	 */
	public function addRoute(string $method, string $uri, callable|array $action): Route
	{
		$route = new Route($method, $uri, $action);
		$this->collection->add($route);
		return $route;
	}

	/**
	 * Add new route with get method
	 *
	 * @param string $uri
	 * @param callable|array $action
	 * @return Route
	 * @throws ParameterHasSameName
	 */
	public function get(string $uri, callable|array $action): Route
	{
		return $this->addRoute('GET', $uri, $action);
	}

	/**
	 * Add new route with post method
	 *
	 * @param string $uri
	 * @param callable|array $action
	 * @return Route
	 * @throws ParameterHasSameName
	 */
	public function post(string $uri, callable|array $action): Route
	{
		return $this->addRoute('POST', $uri, $action);
	}

	/**
	 * Resolve route action
	 *
	 * @param string $method
	 * @param string $uri
	 * @return void
	 * @throws RouteNotFoundException
	 */
	public function resolve(string $method, string $uri)
	{
		$route = $this->collection->get($method, $uri);

		if (is_null($route)) {
			throw new RouteNotFoundException($method, $uri);
		}

		if (is_array($route->action)) {
			return;

			// TODO: Resolve controller
		}

		echo call_user_func_array($route->action, []);
	}
}