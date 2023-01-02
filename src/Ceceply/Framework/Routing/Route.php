<?php

namespace Ceceply\Framework\Routing;

use Ceceply\Framework\Routing\Exception\ParameterHasSameName;

class Route
{
	/**
	 * The method of the route
	 *
	 * @var string
	 */
	public string $method;

	/**
	 * The URI of the route
	 *
	 * @var string
	 */
	public string $uri;

	/**
	 * The parameters of the route
	 *
	 * @var RouteParameter[]
	 */
	public array $parameters = [];

	/**
	 * The action for this route
	 *
	 * @var callable|array
	 */
	public $action;

	/**
	 * Routing constructor
	 *
	 * @param string $method
	 * @param string $uri
	 * @param callable|array $action
	 * @throws ParameterHasSameName
	 */
	public function __construct(string $method, string $uri, callable|array $action)
	{
		$this->method = $method;
		$this->uri = $uri;
		$this->action = $action;
		$this->readUri();
	}

	/**
	 * Read URI to get parameters
	 *
	 * @throws ParameterHasSameName
	 */
	protected function readUri(): void
	{
		foreach (explode('/', $this->uri) as $path) {
			if (str_starts_with($path, '<') && str_ends_with($path, '>')) {
				$name = substr($path, 1, -1);
				$this->addParameter($name);
			}
		}
	}

	/**
	 * Add new route parameter for this route
	 *
	 * @param string $name
	 * @return RouteParameter
	 * @throws ParameterHasSameName
	 */
	protected function addParameter(string $name): RouteParameter
	{
		foreach ($this->parameters as $parameter) {
			if ($parameter->getName() === $name) {
				throw new ParameterHasSameName($name);
			}
		}

		$parameter = new RouteParameter($name);
		$this->parameters[] = $parameter;

		return $parameter;
	}

	/**
	 * Match the given URI with this route URI
	 *
	 * @param string $string
	 * @return bool
	 */
	public function matches(string $string)
	{
		if ($this->hasParameters()) {
			$pattern = $this->uri;

			foreach ($this->parameters as $parameter) {
				$pattern = str_replace("<{$parameter->getName()}>", $parameter->getPattern(), $pattern);
			}

			return (bool)preg_match($pattern, $string);
		}

		return $this->uri === $string;
	}

	/**
	 * Check is this route has parameters
	 *
	 * @return bool
	 */
	public function hasParameters(): bool
	{
		return !empty($this->parameters);
	}

	/**
	 * Get this route method
	 *
	 * @return string
	 */
	public function getMethod(): string
	{
		return $this->method;
	}
}