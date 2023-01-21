<?php

namespace Ceceply\Framework\Foundation;

use Ceceply\Framework\Config\Config;
use Ceceply\Framework\Container\Container;
use Ceceply\Framework\Contract\ApplicationInterface;
use Ceceply\Framework\ExceptionHandler;
use Ceceply\Framework\Request\Request;
use Ceceply\Framework\Routing\Exception\RouteNotFoundException;
use Ceceply\Framework\Routing\Router;
use DirectoryIterator;
use Exception;

class Application implements ApplicationInterface
{
	/**
	 * The base path of project
	 *
	 * @var string
	 */
	protected string $basePath;

	/**
	 * The base path of project config
	 *
	 * @var string
	 */
	protected string $configPath;

	/**
	 * The base path of project route
	 *
	 * @var string
	 */
	protected string $routePath;

	/**
	 * The list of controller paths
	 *
	 * @var array
	 */
	protected array $controllerPath;

	/**
	 * The list of controller namespaces
	 *
	 * @var array
	 */
	protected array $controllerNamespace;

	/**
	 * The application instance
	 *
	 * @var Application
	 */
	public static Application $application;

	/**
	 * The application config
	 *
	 * @var Config
	 */
	protected Config $config;

	/**
	 * The application container
	 *
	 * @var Container
	 */
	public Container $container;

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
	public Router $router;

	/**
	 * Application constructor
	 *
	 * @param array $options
	 */
	public function __construct(array $options)
	{
		$this->readOptions($options);

		self::$application = $this;

		$this->config = new Config($this->loadConfigs());
		$this->container = new Container();
		$this->request = new Request();
		$this->router = new Router($this, $this->request);

		$this->registerToContainer();
		$this->registerControllers();
		$this->loadRoutes();
	}

	/**
	 * Read the given of options
	 *
	 * @param array $options
	 * @return void
	 */
	protected function readOptions(array $options): void
	{
		$this->basePath = $options['paths']['base'];
		$this->configPath = $options['paths']['config'];
		$this->routePath = $options['paths']['route'];
		$this->controllerPath = $options['paths']['controller'];
		$this->controllerNamespace = $options['namespaces']['controller'];
	}

	/**
	 * Load project configs
	 *
	 * @return array
	 */
	protected function loadConfigs(): array
	{
		$configs = [];

		foreach (glob("{$this->configPath}\\*.php") as $file) {
			$configs[pathinfo($file, PATHINFO_FILENAME)] = require_once $file;
		}

		return $configs;
	}

	/**
	 * Register all application properties to container
	 *
	 * @return void
	 */
	protected function registerToContainer(): void
	{
		$this->container->add('app.config', function () {
			return $this->config;
		});

		$this->container->add('app.request', function () {
			return $this->request;
		});

		$this->container->add('app.router', function () {
			return $this->router;
		});
	}

	/**
	 * Register all controllers
	 *
	 * @return void
	 */
	protected function registerControllers(): void
	{
		foreach ($this->controllerPath as $key => $path) {
			foreach (new DirectoryIterator($path) as $file) {
				if ($file->isFile()) {
					$class = $this->controllerNamespace[$key] . $file->getBasename('.php');
					$this->container->add($class);
				}
			}
		}
	}

	/**
	 * Load project routes
	 *
	 * @return void
	 */
	protected function loadRoutes(): void
	{
		foreach (glob("{$this->routePath}\\*.php") as $file) {
			require_once $file;
		}
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
		$content = $this->router->resolve($this->request->method(), $this->request->uri());

		echo $content;
	}

	/**
	 * Get application router
	 *
	 * @return Router
	 */
	public function getRouter(): Router
	{
		return $this->router;
	}
}