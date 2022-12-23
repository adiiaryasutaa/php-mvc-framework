<?php

namespace Ceceply\Framework;

use Ceceply\Framework\View\View;

class Application
{
	public function __construct()
	{

	}

	public function start()
	{
		(new View("Hello World"))->show();
	}
}