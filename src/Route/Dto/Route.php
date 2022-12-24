<?php

namespace Ceceply\Framework\Route\Dto;

use Ceceply\Framework\Route\Exception\BindingHasBeenDefinedException;

class Route
{
	public string $method;
	public string $uri;
	public array $parameters = [];
	/**
	 * @var callable|array
	 */
	public $action;

	/**
	 * @param string $method
	 * @param string $uri
	 * @param callable|array $action
	 * @throws BindingHasBeenDefinedException
	 */
	public function __construct(string $method, string $uri, callable|array $action)
	{
		$this->method = $method;
		$this->uri = $uri;
		$this->action = $action;
		$this->readParameters();
	}

	/**
	 * @throws BindingHasBeenDefinedException
	 */
	protected function readParameters(): array
	{
		$paths = $this->getSplitUri();

		foreach ($paths as $index => $path) {
			if ($this->isParameter($path)) {
				$name = substr($path, 1, -1);
				$this->addParameter($name, $index);
			}
		}

		return $this->parameters;
	}

	public function getSplitUri(): array
	{
		return explode('/', $this->uri);
	}

	protected function isParameter(string $string): bool
	{
		return str_starts_with($string, '<') && str_ends_with($string, '>');
	}

	/**
	 * @throws BindingHasBeenDefinedException
	 */
	protected function addParameter(string $name, int $position)
	{
		if (isset($this->parameters[$name])) {
			throw new BindingHasBeenDefinedException($name);
		}

		$this->parameters[$name] = ['position' => $position];
	}

	public function hasParameters(): bool
	{
		return !empty($this->parameters);
	}

	public function isMatch(string $uri): bool
	{
		if ($this->hasParameters()) {
			$thisPaths = array_merge(array_diff_key($this->getSplitUri(), $this->getParameterPositions()));
			$paths = explode('/', $uri);

			for ($i = 0; $i < count($thisPaths); $i++) {
				if ($thisPaths[$i] !== $paths[$i]) {
					return false;
				}
			}
		}

		return $this->uri === $uri;
	}

	protected function getParameterPositions(): array
	{
		$positions = [];

		foreach ($this->parameters as $parameter) {
			$positions[] = $parameter['position'];
		}

		return $positions;
	}

	public function whichOneIsTheArguments($uri): array
	{
		$path = explode('/', $uri);
		$arguments = [];

		foreach ($this->getParameterPositions() as $position) {
			$arguments[] = $path[$position];
		}

		return $arguments;
	}
}