<?php

namespace S4mpp\AdminPanel\Labels;

use S4mpp\AdminPanel\Column\Column;

final class Datetime extends Label
{
	function __construct(private ?string $title = null, private ?string $field = null, private string $format)
	{
		parent::__construct($title, $field);
	}

	// public function render($value, $sequence)
	// {
	// 	$format = $this->format;

	// 	return view('admin::label.datetime', compact('value', 'sequence', 'format'));
	// }

	public function showContent($content = null)
	{
		$format = $this->format;
		
		return view('admin::labels.datetime', compact('content', 'format'));
	}
}