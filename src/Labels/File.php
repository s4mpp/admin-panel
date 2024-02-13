<?php

namespace S4mpp\AdminPanel\Labels;

final class File extends Label
{
	// public function renderView($value)
	// {
	// 	$item = $this;

	// 	return view('admin::label.file', compact('value', 'item'));
	// }

	public function showContent($content = null)
	{
		return view('admin::labels.file', compact('content'));
	}
}