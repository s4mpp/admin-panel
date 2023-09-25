<?php

namespace S4mpp\AdminPanel\Elements;

use S4mpp\AdminPanel\Elements\ElementInteface;

class ItemView implements ElementInteface
{
	public array $class = [];

	public string $type = 'text';

	public $callback = null;

	public string $format_datetime = 'd/m/Y H:i';

	public ?string $default_text = null;
 		
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

	public function file()
	{
		$this->type = 'file';

		return $this;
	}

	public function default(string $default_text)
	{
		$this->default_text = $default_text;

		return $this;
	}

	public function callback(callable $callback)
	{
		$this->callback = $callback;

		return $this;
	}

	public function datetime(string $format = 'd/m/Y H:i')
	{
		$this->type = 'datetime';

		$this->format_datetime = $format;

		return $this;
	}

	public function relation(string $fk_field)
	{
		$this->is_relation = true;

		$this->fk_field = $fk_field;

		$this->callback(function($item) use ($fk_field)
		{
			return $item->{$fk_field} ?? null;
		});

		return $this;
	}

	
}