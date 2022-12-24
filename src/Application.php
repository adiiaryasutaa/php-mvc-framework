<?php

namespace Ceceply\Framework;

use Ceceply\Framework\Contract\ApplicationContract;
use Ceceply\Framework\Route\Router;

class Application implements ApplicationContract
{
	public Router $route;

	public function __construct()
	{
		$this->route = new Router($this);
	}

	public function start()
	{
		$this->route->resolve();
	}
}