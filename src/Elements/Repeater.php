<?php

namespace S4mpp\AdminPanel\Elements;

use S4mpp\AdminPanel\Utils;
use S4mpp\AdminPanel\Resource;
use S4mpp\AdminPanel\Column\Column;
use S4mpp\AdminPanel\Traits\Slugable;
use S4mpp\AdminPanel\Traits\Titleable;
use Illuminate\Database\Eloquent\Model;
use S4mpp\AdminPanel\Column\RepeaterActions;

final class Repeater
{
	use Titleable, Slugable;

	private $model = null;

	private string $order_field = 'id';

	private string $order_direction = 'DESC';

	function __construct(private string $title, private string $relation, private array $fields, private array $columns)
	{
		$this->createSlug($title);

		return $this;
	}

	public function order(string $field = 'id', string $direction = 'DESC')
	{
		$this->order_field = $field;

		$this->order_direction = $direction;

		return $this;
	}

	public function getFieldOrderBy()
	{
		return $this->order_field;
	} 
	
	public function getDirectionOrderBy()
	{
		return $this->order_direction;
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