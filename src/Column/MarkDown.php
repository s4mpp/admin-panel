<?php

namespace S4mpp\AdminPanel\Column;

use S4mpp\AdminPanel\Column\Column;

final class MarkDown extends Column
{
	public function render($value, $sequence)
	{
		return view('admin::label.markdown', compact('value'));
	}
}