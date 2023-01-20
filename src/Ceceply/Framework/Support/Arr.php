<?php

namespace Ceceply\Framework\Support;

class Arr
{
	public static function get(array $array, string|int $key, mixed $default = null)
	{
		if (self::exists($array, $key)) {
			return $array[$key];
		}

		if (!str_contains($key, '.')) {
			return $array[$key] ?? $default;
		}

		foreach (explode('.', $key) as $segment) {
			if (is_array($array) && self::exists($array, $segment)) {
				$array = $array[$segment];
			} else {
				return $default;
			}
		}

		return $array;
	}

	public static function exists(array $array, string|int $key): bool
	{
		return array_key_exists($key, $array);
	}
}