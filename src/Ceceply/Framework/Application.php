<?php

namespace Ceceply\Framework;

use Ceceply\Framework\Contract\ApplicationContract;
use Ceceply\Framework\Request\Request;
use Ceceply\Framework\Routing\Router;
use Exception;

class Application implements ApplicationContract
{
	/**
	 * The current request
	 *
	 * @var Request
	 */
	public Request $request;

	/**
	 * The app router
	 *
	 * @var Router
	 */
	public Router $route;

	/**
	 * Application constructor
	 */
	public function __construct()
	{
		$this->request = new Request();
		$this->route = new Router($this, $this->request);
	}

	/**
	 * Start application
	 *
	 * @return void
	 */
	public function start(): void
	{
		try {
			$this->route->resolve($this->request->method(), $this->request->uri());
		} catch (Exception $exception) {
			(new ExceptionHandler($exception))->show();
		}
	}
}