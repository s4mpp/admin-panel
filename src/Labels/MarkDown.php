<?php

namespace S4mpp\AdminPanel\Labels;

use S4mpp\AdminPanel\Column\Column;

final class MarkDown extends Label
{
	// public function render($value, $sequence)
	// {
	// 	return view('admin::label.markdown', compact('value'));
	// }

	public function showContent($content = null)
	{
		return view('admin::labels.markdown', compact('content'));
	}
}