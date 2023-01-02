<?php

namespace Ceceply\Framework\Routing;

class RouteParameterPattern
{
	/**
	 * The pattern for route parameter
	 * The `{}` is placeholder
	 *
	 * @var string
	 */
	protected static string $pattern = '^<.*\.>$';

	/**
	 * Match the given string with parameter pattern
	 *
	 * @param string $string
	 * @return bool
	 */
	public static function match(string $string)
	{
		return (bool)preg_match(self::$pattern, $string);
	}

	public static function make(string $string)
	{

	}
}