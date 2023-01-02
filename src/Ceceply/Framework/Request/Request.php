<?php

namespace Ceceply\Framework\Request;

class Request
{
	public function method()
	{
		return $_SERVER['REQUEST_METHOD'];
	}

	public function uri()
	{
		return $_SERVER['REQUEST_URI'] ?? '/';
	}
}