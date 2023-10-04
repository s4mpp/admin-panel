<?php

namespace S4mpp\AdminPanel\Elements;

use Illuminate\Support\Str;
use S4mpp\AdminPanel\Traits\HasLabel;

class Column
{
	use HasLabel;

	private ?string $alignment = null;

	function __construct(public $title, public $field)
	{}

	public static function create(string $title, string $field)
	{
		return new Column($title, $field);
	}

	public function align(string $alignment)
	{
		$this->alignment = in_array($alignment,['left', 'center', 'right']) ? $alignment : null;
			
		return $this;
	}
}