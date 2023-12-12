<?php

namespace S4mpp\AdminPanel\Column;

use S4mpp\AdminPanel\Traits\HasLabel;
use S4mpp\AdminPanel\Traits\HasDefaultText;
use S4mpp\AdminPanel\Traits\Titleable;

class Column
{
	use HasDefaultText, HasLabel, Titleable;

	private ?string $alignment = null;

	private $is_relation = false;

	function __construct(private ?string $title = null, private ?string $field = null)
	{
		if(strpos($field, '.') !== false)
		{
			$this->is_relation = true;
		}
	}

	public function align(string $alignment)
	{
		$this->alignment = in_array($alignment, ['left', 'center', 'right']) ? $alignment : null;
			
		return $this;
	}

	public function getAlignment(): ?string
	{
		return $this->alignment;
	}

	public function getField(): ?string
	{
		return $this->field;
	}

	public function isRelation()
	{
		return $this->is_relation;
	}

	// public function relation()
	// {
	// 	$this->is_relation = true;

	// 	return $this;
	// }
}