<?php

namespace S4mpp\AdminPanel\Elements;

use Illuminate\Database\Eloquent\Model;

class Repeater
{
	function __construct(private string $title, private string $relation, private array $fields)
	{}

	public static function create(string $title, string $relation, array $fields)
	{
		return new Repeater($title, $relation, $fields);
	}

	public function getRelation(): string
	{
		return $this->relation;
	}

	public function getFields(): array
	{
		return $this->fields;
	}
	
	public function getTitle(): string
	{
		return $this->title;
	}

	// public function render($resource)
	// {
	// 	return view('admin::elements.card', ['card' => $this, 'resource' => $resource]);
	// }
}