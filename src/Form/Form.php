<?php

namespace S4mpp\AdminPanel\Form;

use Illuminate\Database\Eloquent\Model;

class Form
{
	public array $fields = [];

	function __construct(public ?Model $resource = null)
	{}

	public function fields(array $fields)
	{
		$this->fields = $fields;

		// foreach($this->original_collection as $i => $row)
		// {
		// 	$data_row = [];
			
		// 	foreach($fields as $column)
		// 	{
		// 		$data = clone $column;

		// 		$data->original_data =  $row->{$column->field};
		// 		$data->data = is_callable($column->callback) ? call_user_func($column->callback, $data->original_data) : $data->original_data;

		// 		$data_row[$column->field] = $data;
		// 	}

		// 	$this->data[$row->id] = $data_row;
		// }

		return $this;
	}
}