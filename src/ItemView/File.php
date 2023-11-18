<?php

namespace S4mpp\AdminPanel\ItemView;

use S4mpp\AdminPanel\ItemView\ItemView;

final class File extends ItemView
{
	public function renderView($value, $item)
	{
		return view('admin::label.file', compact('value', 'item'));
	}
}