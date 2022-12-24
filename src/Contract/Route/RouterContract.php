<?php

namespace Ceceply\Framework\Contract\Route;

interface RouterContract
{
	public function add(string $method, string $uri, callable|array $action);

	public function resolve();
}