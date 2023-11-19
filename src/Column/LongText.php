<?php

namespace S4mpp\AdminPanel\Column;

use S4mpp\AdminPanel\Column\Column;

final class LongText extends Column
{
	public function render($value, $sequence)
	{
		return view('admin::label.longtext', compact('value'));
	}
}