<?php

namespace Ceceply\Framework\Container;

use Ceceply\Framework\Contract\Container\ContainerInterface;
use Closure;

class Container implements ContainerInterface
{
	protected array $entries = [];

	public function __construct()
	{

	}

	public function add(string $abstract, string|Closure|null $concrete = null)
	{
		if (is_null($concrete)) {
			$concrete = $abstract;
		}

		if (is_string($concrete)) {
			$concrete = new $concrete;
		}

		if ($concrete instanceof Closure) {
			$concrete = $concrete($this);
		}

		$this->entries[$abstract] = $concrete;
	}

	public function has(string $abstract): bool
	{
		return isset($this->entries[$abstract]);
	}

	public function get(string $abstract)
	{
		return $this->has($abstract) ? $this->entries[$abstract] : null;
	}
}