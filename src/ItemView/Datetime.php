<?php

namespace S4mpp\AdminPanel\ItemView;

use S4mpp\AdminPanel\ItemView\ItemView;

final class Datetime extends ItemView
{
	function __construct(private string $title, private string $field, private string $format)
	{
		parent::__construct($title, $field);
	}

	public function renderView($value)
	{
		$format = $this->format;

		return view('admin::label.datetime', compact('value', 'format'));
	}
}