<?php

namespace Ceceply\Framework\Foundation;

use Ceceply\Framework\Contract\ApplicationInterface;
use Ceceply\Framework\ExceptionHandler;
use Ceceply\Framework\Request\Request;
use Ceceply\Framework\Routing\Exception\RouteNotFoundException;
use Ceceply\Framework\Routing\Router;
use Exception;

class Application implements ApplicationInterface
{
	private string $baseUrl;

	private string $urlPath;

	/**
	 * The current request
	 *
	 * @var Request
	 */
	public Request $request;

	/**
	 * The app router
	 *
	 * @var Router
	 */
	public Router $route;

	/**
	 * Application constructor
	 */
	public function __construct(string $baseUrl, string $urlPath)
	{
		$this->baseUrl = $baseUrl;
		$this->urlPath = $urlPath;

		$this->request = new Request();
		$this->route = new Router($this, $this->request);
	}

	/**
	 * Start application
	 *
	 * @return void
	 */
	public function start(): void
	{
		try {
			$this->handleRequest();
		} catch (Exception $exception) {
			(new ExceptionHandler($exception))->show();
		}
	}

	/**
	 * Handle incoming requests
	 *
	 * @throws RouteNotFoundException
	 */
	protected function handleRequest()
	{
		$content = $this->route->resolve($this->request->method(), $this->request->uri());

		echo $content;
	}

	/**
	 * @return string
	 */
	public function getBaseUrl(): string
	{
		return $this->baseUrl;
	}

	/**
	 * @return string
	 */
	public function getUrlPath(): string
	{
		return $this->urlPath;
	}

	/**
	 * @return Request
	 */
	public function getRequest(): Request
	{
		return $this->request;
	}

	/**
	 * @return Router
	 */
	public function getRoute(): Router
	{
		return $this->route;
	}
}