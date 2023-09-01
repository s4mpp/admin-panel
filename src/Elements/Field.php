<?php

namespace S4mpp\AdminPanel\Elements;

use Illuminate\Database\Eloquent\Collection;
use S4mpp\AdminPanel\Elements\ElementInteface;

class Field implements ElementInteface
{
	public array $class = [];

	public string $type = 'text';
	
	public array $rules = ['required', 'string'];

	public array $additional_data = [];
	
	public array $attributes = [];

	public ?int $rows = null;
	
	public float $min = 0;
		
	public ?float $max = null;
	
	public ?float $step = null;

	function __construct(public $title, public $name)
	{}

	public static function create(string $title, string $name)
	{
		return new Field($title, $name);
	}

	public function render($resource = null)
	{
		return view('admin::elements.field', ['field' => $this, 'resource' => $resource]);
	}

	public function col(string $size, int $column_size)
	{
		$this->class[] = $size.':w-'.$column_size.'/12';	

		return $this;
	}

	public function email()
	{
		$this->type = 'email';

		$this->rules[] = 'email';
		
		return $this;
	}

	public function unique()
	{
		$this->rules[] = 'unique';
		
		return $this;
	}

	public function date()
	{
		$this->type = 'date';

		return $this;
	}

	public function textarea()
	{
		$this->type = 'textarea';

		return $this;
	}

	public function rows(int $rows)
	{
		$this->rows = $rows;

		return $this;
	}

	public function decimal()
	{
		$this->type = 'number';

		$this->step = 0.01;

		$this->rules[] = 'numeric';

		return $this;
	}

	public function integer()
	{
		$this->type = 'number';

		$this->step = 1;
		
		$this->rules[] = 'integer';

		return $this;
	}

	public function min(float $min)
	{
		$this->min = $min;

		$this->rules[] = 'min:'.$min;

		return $this;
	}

	public function max(float $max)
	{
		$this->max = $max;

		$this->rules[] = 'max:'.$max;

		return $this;
	}

	public function boolean()
	{
		$this->type = 'boolean';

		$this->notRequired();

		$this->rules[] = 'boolean';

		return $this;
	}

	public function enum(array $cases)
	{
		$this->type = 'select';

		$options = [];

		foreach($cases as $case)
		{
			$options[] = [
				'id' => $case->value,
				'label' => (method_exists($case, 'label')) ? $case->label() : $case->name,
			];
		}
		
		$this->additional_data['options'] = $options;

		return $this;
	}

	public function permissions(array $permissions)
	{
		$this->type = 'permissions';

		$options = [];

		foreach($permissions as $permission => $label)
		{
			$options[] = [
				'id' => $permission,
				'label' => $label,
			];
		}
		
		$this->additional_data['permissions'] = $options;

		$this->_removeRule('string');

		$this->rules[] = 'array';

		return $this;
	}

	public function relation(Collection $model_options, string $fk_relation)
	{
		$this->type = 'select';

		$options = [];

		foreach($model_options as $model_item)
		{
			$options[] = [
				'id' => $model_item->id,
				'label' => $model_item->{$fk_relation},
			];
		}
		
		$this->additional_data['options'] = $options;

		return $this;
	}

	public function notRequired()
	{
		$this->_removeRule('required');
		
		$this->rules[] = 'nullable';

		return $this;
	}

	private function _removeRule(string $rule)
	{
		$key = array_search($rule, $this->rules);
		
		if($key !== false)
		{
			unset($this->rules[$key]);
		}
	}

}