<?php

namespace Ceceply\Framework\Routing;

class RouteParameter
{
	/**
	 * The name of parameter
	 *
	 * @var string
	 */
	protected string $name;

	/**
	 * The pattern of parameter
	 *
	 * @var string
	 */
	protected string $pattern;

	/**
	 * Routing parameter constructor
	 *
	 * @param string $name
	 * @param string|null $pattern
	 */
	public function __construct(string $name, ?string $pattern = '^[a-zA-Z0-9_.-]*$')
	{
		$this->name = $name;
		$this->pattern = $pattern;
	}

	/**
	 * Get parameter name
	 *
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * Get parameter pattern
	 *
	 * @return string
	 */
	public function getPattern(): string
	{
		return $this->pattern;
	}
}