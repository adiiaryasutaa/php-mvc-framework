<?php

namespace Ceceply\Framework\Contract\Route;

interface RouteContract
{
	public function add(string $method, string $uri, callable $concrete);

	public function resolve();
}