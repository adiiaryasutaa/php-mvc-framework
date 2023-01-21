<?php

namespace Ceceply\Framework\Contract\Container;

use Closure;

interface ContainerInterface
{
	public function add(string $abstract, Closure|string|null $concrete);

	public function has(string $abstract);

	public function get(string $abstract);
}