<?php

namespace S4mpp\AdminPanel\Elements;

use S4mpp\AdminPanel\Elements\ElementInteface;

class ItemView implements ElementInteface
{
	public array $class = [];

	public string $type = 'text';
 		
	function __construct(public $title, public $value)
	{}

	public static function create(string $title, string $name)
	{
		return new ItemView($title, $name);
	}

	public function render($resource = null)
	{
		return view('admin::elements.item-view', ['item' => $this, 'resource' => $resource]);
	}

	public function col(string $size, int $column_size)
	{
		$this->class[] = 'col-'.$size.'-'.$column_size;

		return $this;
	}

	public function boolean()
	{
		$this->type = 'boolean';

		return $this;
	}

	public function enum()
	{
		$this->type = 'enum';

		return $this;
	}

	public function markDown()
	{
		$this->type = 'markdown';

		return $this;
	}
}