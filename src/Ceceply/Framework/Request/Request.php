<?php

namespace Ceceply\Framework\Request;

class Request
{
	/**
	 * Get current requested method
	 *
	 * @return string
	 */
	public function method()
	{
		return $_SERVER['REQUEST_METHOD'];
	}

	/**
	 * Get current requested uri
	 *
	 * @return string
	 */
	public function uri()
	{
		return trim($_SERVER['REQUEST_URI'], '/');
	}
}