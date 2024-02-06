<?php

namespace S4mpp\AdminPanel\Labels;

final class Badge extends Label
{
	// public function render($value, $sequence)
	// {
	// 	return view('admin::label.badge', compact('value', 'sequence'));
	// }

	public function showContent($content = null)
	{
		return view('admin::labels.badge', compact('content'));
	}
}