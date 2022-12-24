<?php

namespace Ceceply\Framework\Route\Dto;

class Route
{
	public string $method;

	public string $uri;

	/**
	 * @var callable|array
	 */
	public $action;

	/**
	 * @param string $method
	 * @param string $uri
	 * @param callable|array $action
	 */
	public function __construct(string $method, string $uri, callable|array $action)
	{
		$this->method = $method;
		$this->uri = $uri;
		$this->action = $action;
	}
}