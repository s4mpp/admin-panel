<?php

namespace S4mpp\AdminPanel\Elements;

use S4mpp\AdminPanel\Factories\Column;
use S4mpp\AdminPanel\Traits\Titleable;
use S4mpp\AdminPanel\Column\RepeaterActions;
use S4mpp\AdminPanel\Traits\Slugable;

final class Repeater
{
	use Titleable, Slugable;

	private $model = null;

	function __construct(private string $title, private string $relation, private array $fields)
	{
		$this->createSlug($title);
	}

	public function setRelationShipMethod($model)
	{
		$this->model = $model;

		return $this;
	}

	public function getRelation(): string
	{
		return $this->relation;
	}

	public function getModelRelation()
	{
		return $this->model->getRelated();
	}

	public function getFields(): array
	{
		return $this->fields;
	}

	public function getColumns(): array
	{
		$columns = [
			Column::text('ID', 'id'),
		];
		
		array_push($columns, (new RepeaterActions($this->relation))->align('right'));

		return $columns;
	}
}