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
	 * The list of nested views
	 *
	 * @var View[]
	 */
	protected array $nests = [];

	/**
	 * Is view built?
	 *
	 * @var bool
	 */
	protected bool $built = false;

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
	 * Add nested view
	 *
	 * @param string $replace
	 * @param View $view
	 * @return $this
	 */
	public function nest(string $replace, View $view): static
	{
		$this->nests[$replace] = $view;

		return $this;
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

	/**
	 * Content getter
	 *
	 * @return string
	 */
	public function getContent(): string
	{
		return $this->content;
	}

	public function getNests(): array
	{
		return $this->nests;
	}

	/**
	 * Show content of this view
	 *
	 * @return string
	 */
	public function __toString(): string
	{
		return $this->getContent();
	}
}