<?php

namespace Ceceply\Framework\View;

class View
{
	protected string $content;

	public function __construct(string $content)
	{
		$this->content = $content;
	}

	public function show()
	{
		echo $this->content;
	}
}