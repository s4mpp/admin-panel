<?php

namespace S4mpp\AdminPanel\Table;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use stdClass;

class Table
{
	public array $data = [];

	public array $columns = [];
		
	public array $actions = [];

	function __construct(public Collection | LengthAwarePaginator $original_collection)
	{}

	public function columns(array $columns)
	{
		$this->columns = $columns;

		foreach($this->original_collection as $i => $row)
		{
			$data_row = [];
			
			foreach($columns as $column)
			{
				$data = clone $column;

				$data->original_data =  $row->{$column->field};
				$data->data = is_callable($column->callback) ? call_user_func($column->callback, $data->original_data) : $data->original_data;

				$data_row[$column->field] = $data;
			}

			$this->data[$row->id] = $data_row;
		}

		return $this;
	}

	public function actions(array $actions)
	{
		$this->actions = $actions;

		return $this;
	}
}