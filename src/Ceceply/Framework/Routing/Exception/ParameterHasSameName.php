<?php

namespace Ceceply\Framework\Routing\Exception;

use Exception;

class ParameterHasSameName extends Exception
{
	protected string $name;

	public function __construct(string $name)
	{
		$this->name = $name;
		parent::__construct("This [$name] binding has been defined before");
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}
}