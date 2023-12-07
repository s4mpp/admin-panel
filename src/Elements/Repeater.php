<?php

namespace S4mpp\AdminPanel\Elements;

use S4mpp\AdminPanel\Utils;
use S4mpp\AdminPanel\Resource;
use S4mpp\AdminPanel\Column\Column;
use S4mpp\AdminPanel\Traits\Slugable;
use S4mpp\AdminPanel\Traits\Titleable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use S4mpp\AdminPanel\Column\RepeaterActions;
use S4mpp\AdminPanel\Factories\Column as ColumnFactory;

final class Repeater
{
	use Titleable, Slugable;

	private $model = null;

	function __construct(private string $title, private string $relation, private array $fields, private array $columns)
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

	public function getTotalRegisters(Resource $resource, Model $register): int
	{
		return $resource->getModel()->select('id')
			->find($register->id)
			->{$this->getRelation()}()
			->count();
	}

	public function getColumns(): array
	{
		return Utils::getOnlyOf($this->columns, Column::class);
	}

	public function getColumnsWithActions(): array
	{
		$columns = $this->getColumns();
		
		array_push($columns, (new RepeaterActions($this->relation))->align('right'));

		return $columns;
	}
}