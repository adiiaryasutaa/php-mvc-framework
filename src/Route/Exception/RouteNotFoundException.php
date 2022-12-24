<?php

namespace Ceceply\Framework\Route\Exception;

use Ceceply\Framework\Route\Dto\Route;
use Exception;

class RouteNotFoundException extends Exception
{
	protected string $method;

	protected string $uri;

	public function __construct(string $method, string $uri)
	{
		$this->method = $method;
		$this->uri = $uri;

		parent::__construct("Route not found [method: $this->method, uri: $this->uri]");
	}

	/**
	 * @return string
	 */
	public function getMethod(): string
	{
		return $this->method;
	}

	/**
	 * @return string
	 */
	public function getUri(): string
	{
		return $this->uri;
	}
}