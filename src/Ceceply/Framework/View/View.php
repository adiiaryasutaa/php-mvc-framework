<?php

namespace Ceceply\Framework\View;

class View
{
	/**
	 * The content of this view
	 *
	 * @var string
	 */
	protected string $content;

	/**
	 * View constructor
	 *
	 * @param string $content
	 */
	public function __construct(string $content = '')
	{
		$this->content = $content;
	}

	/**
	 * Show content of this view
	 *
	 * @return void
	 */
	public function show(): void
	{
		echo $this->content;
	}

	/**
	 * Make new view
	 *
	 * @param $content
	 * @return View
	 */
	public static function make($content): View
	{
		return (new View($content));
	}
}