<?php

namespace Ceceply\Framework;

use Ceceply\Framework\Contract\ApplicationContract;
use Ceceply\Framework\Request\Request;
use Ceceply\Framework\Routing\Router;
use Exception;

class Application implements ApplicationContract
{
	public Request $request;
	public Router $route;

	public function __construct()
	{
		$this->request = new Request();
		$this->route = new Router($this, $this->request);
	}

	public function start()
	{
		try {
			$this->route->resolve($this->request->method(), $this->request->uri());
		} catch (Exception $exception) {
			(new ExceptionHandler($exception))->show();
		}
	}
}