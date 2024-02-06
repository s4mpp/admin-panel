<?php

namespace S4mpp\AdminPanel\Labels;

final class Actions extends Label
{
	private array $actions = [];

	public function setActions(array $actions)
	{
		$this->actions = $actions;

		return $this;
	}

	public function getActions(): array
	{
		return $this->actions;
	}

	public function render($content = null)
	{
		return view('admin::labels.actions', ['actions' => $this->actions, 'content' => $content]);
	}
}