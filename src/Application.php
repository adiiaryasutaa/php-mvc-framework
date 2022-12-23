<?php

namespace Ceceply\Framework;

use Ceceply\Framework\Route\Route;
use Ceceply\Framework\View\View;

class Application
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