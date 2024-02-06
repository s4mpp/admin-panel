<?php

namespace S4mpp\AdminPanel\Labels;

use S4mpp\AdminPanel\Column\Column;

final class Boolean  extends Label
{
	// public function render($value, $sequence)
	// {
	// 	return view('admin::label.boolean', compact('value', 'sequence'));
	// }

	public function showContent($content = null)
	{
		return view('admin::labels.boolean', compact('content'));
	}
}