<?php

namespace S4mpp\AdminPanel\Column;

final class RepeaterActions extends Column
{
	public function __construct(private string $relation)
	{
		parent::__construct('', null);
	}

	public function render($value, $sequence)
	{
		return view('admin::columns.repeater-actions', ['relation' => $this->relation, 'value' => $value, 'sequence' => $sequence]);
	}
}