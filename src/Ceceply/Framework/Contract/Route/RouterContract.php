<?php

namespace Ceceply\Framework\Contract\Route;

interface RouterContract
{
	public function addRoute(string $method, string $uri, callable|array $action);

	public function resolve(string $method, string $uri);
}