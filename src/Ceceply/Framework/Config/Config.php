<?php

namespace Ceceply\Framework\Config;

use Ceceply\Framework\Support\Arr;

class Config
{
	protected array $items = [];

	/**
	 * @param array $items
	 */
	public function __construct(array $items = [])
	{
		$this->items = $items;
	}

	public function get(string $key, mixed $default = null)
	{
		return Arr::get($this->items, $key, $default);
	}

	public function exists(string $key): bool
	{
		return Arr::exists($this->items, $key);
	}
}