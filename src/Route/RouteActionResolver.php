<?php

namespace Ceceply\Framework\Route;

class RouteActionResolver
{
	public function resolve(callable|array $action)
	{
		if (is_callable($action)) {
			return $action();
		}

		$controller = new $action[0];
		$method = $action[1];

		return call_user_func([$controller, $method]);
	}
}