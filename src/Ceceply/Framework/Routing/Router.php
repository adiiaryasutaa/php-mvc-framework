<?php

namespace Ceceply\Framework\Routing;

use Ceceply\Framework\Contract\Route\RouterInterface;
use Ceceply\Framework\Foundation\Application;
use Ceceply\Framework\Request\Request;
use Ceceply\Framework\Routing\Exception\ParameterHasSameName;
use Ceceply\Framework\Routing\Exception\RouteNotFoundException;
use Ceceply\Framework\View\View;
use Ceceply\Framework\View\ViewBuilder;

class Router implements RouterInterface
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
	 * @return View
	 * @throws RouteNotFoundException
	 */
	public function resolve(string $method, string $uri): View
	{
		$route = $this->collection->get($method, $uri);

		if (is_null($route)) {
			throw new RouteNotFoundException($method, $uri);
		}

		if (is_array($route->action)) {
			$action = [new $route->action[0], $route->action[1]];
		} else {
			$action = $route->action;
		}

		$parameters = [];

		$content = call_user_func_array($action, $parameters);

		if (is_string($content)) {
			$content = View::make($content);
		}

		/**
		 * @var View $content
		 */

		return (new ViewBuilder($content))->build();
	}
}