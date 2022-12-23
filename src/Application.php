<?php

namespace Ceceply\Framework;

use Ceceply\Framework\Contract\ApplicationContract;
use Ceceply\Framework\Route\Route;

class Application implements ApplicationContract
{
	public Route $route;

	public function __construct()
	{
		$this->route = new Route($this);
	}

	public function start()
	{
		$this->route->resolve();
	}
}