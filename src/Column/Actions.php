<?php

namespace S4mpp\AdminPanel\Column;

final class Actions extends Column
{
	public function __construct(private array $actions = [])
	{
		parent::__construct('', 'id');
	}

	public function render($value, $sequence)
	{
		return view('admin::columns.actions', ['actions' => $this->actions, 'value' => $value, 'sequence' => $sequence]);
	}
}