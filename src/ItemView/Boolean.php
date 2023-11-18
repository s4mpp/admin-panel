<?php

namespace S4mpp\AdminPanel\ItemView;

use S4mpp\AdminPanel\ItemView\ItemView;

final class Boolean extends ItemView
{
	public function renderView($value)
	{
		return view('admin::label.boolean', compact('value'));
	}
}