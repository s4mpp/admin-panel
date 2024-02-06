<?php

namespace S4mpp\AdminPanel\Labels;

use S4mpp\AdminPanel\Column\Column;

final class LongText extends Label
{
	// public function render($value, $sequence)
	// {
	// 	return view('admin::label.longtext', compact('value'));
	// }

	public function showContent($content = null)
	{
		return view('admin::labels.longtext', compact('content'));
	}
}