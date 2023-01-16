<?php

namespace Ceceply\Framework\View;

class ViewBuilder
{
	protected View $view;

	/**
	 * View builder constructor
	 *
	 * @param View $view
	 */
	public function __construct(View $view)
	{
		$this->view = $view;
	}

	/**
	 * Build view and return new view
	 *
	 * @return View
	 */
	public function build(): View
	{
		$content = $this->view->getContent();

		foreach ($this->view->getNests() as $replace => $view) {
			$content = str_replace($replace, $view->getContent(), $content);
		}

		return View::make($content);
	}
}