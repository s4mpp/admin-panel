<?php

namespace S4mpp\AdminPanel\ItemView;

use S4mpp\AdminPanel\ItemView\ItemView;

final class File extends ItemView
{
	function __construct(private string $title, private string $field, private string $driver)
	{
		parent::__construct($title, $field);
	}

	public function renderView($value, $item)
	{
		return view('admin::label.file', compact('value', 'item'));
	}

	public function getDriver()
	{
		return $this->driver;
	}
}