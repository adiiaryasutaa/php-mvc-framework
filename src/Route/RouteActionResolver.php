<?php

namespace Ceceply\Framework\Route;

class RouteActionResolver
{
	public function resolve(callable|array $action, $params = [])
	{
		if (is_callable($action)) {
			return $action(...$params);
		}

		$controller = new $action[0];
		$method = $action[1];

		return call_user_func_array([$controller, $method], $params);
	}
}