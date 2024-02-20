<?php

namespace S4mpp\AdminPanel\Labels;

use S4mpp\AdminPanel\Utils;
use S4mpp\AdminPanel\Resource;
use S4mpp\AdminPanel\Column\Column;
use S4mpp\AdminPanel\Traits\Slugable;
use S4mpp\AdminPanel\Traits\Titleable;
use Illuminate\Database\Eloquent\Model;
use S4mpp\AdminPanel\Column\RepeaterActions;

abstract class Label
{
	use Titleable;

	private bool $strong = false;

	private ?string $alignment = 'left';

	function __construct(private string $title, private string $field)
	{}

	public function strong()
	{
		$this->strong = true;

		return $this;
	}

	public function getIsStrong(): bool
	{
		return $this->strong;
	}

	public function getField(): ?string
	{
		return $this->field;
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

	// public function renderItemView($content = null)
	// {
	// 	return view('admin::labels.read-label', ['item' => $this, 'content' => $content]);
	// }

	public function showContent($content = null)
	{
		return $content;
	}
}