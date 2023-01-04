<?php

namespace Ceceply\Framework\Contract\Route;

interface RouterInterface
{
	public function addRoute(string $method, string $uri, callable|array $action);

	public function resolve(string $method, string $uri);
}