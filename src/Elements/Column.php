<?php

namespace S4mpp\AdminPanel\Elements;

use Illuminate\Support\Str;
use S4mpp\AdminPanel\Traits\HasDefaultText;
use S4mpp\AdminPanel\Traits\HasLabel;

class Column
{
	use HasLabel, HasDefaultText;

	private ?string $alignment = null;

	function __construct(private string $title, private string $field)
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

	public function getAlignment(): ?string
	{
		return $this->alignment;
	}

	public function getField(): string
	{
		return $this->field;
	}

	public function getTitle(): string
	{
		return $this->title;
	}
}