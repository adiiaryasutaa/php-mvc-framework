<?php

namespace Ceceply\Framework;

use Exception;

class ExceptionHandler
{
	protected Exception $exception;

	/**
	 * @param Exception $exception
	 */
	public function __construct(Exception $exception)
	{
		$this->exception = $exception;
	}

	public function show()
	{
		echo '<pre>';
		print_r($this->exception->getMessage());
		echo '</pre>';
	}
}