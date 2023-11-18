<?php

namespace S4mpp\AdminPanel\Column;

use S4mpp\AdminPanel\Column\Column;

final class Boolean extends Column
{
	public function render($value, $sequence)
	{
		return view('admin::label.boolean', compact('value', 'sequence'));
	}
}