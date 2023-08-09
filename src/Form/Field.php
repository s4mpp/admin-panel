<?php

namespace S4mpp\AdminPanel\Form;

use Illuminate\Database\Eloquent\Collection;

class Field
{
	public string $type = 'text';
	
	public array $rules = ['required', 'string'];

	public array $additional_data = [];
	
	public array $attributes = [];

	public float $min = 0;
	
	public ?float $max = null;
	
	public ?float $step = null;

	function __construct(public $title, public $name)
	{}

	public static function create(string $title, string $name)
	{
		return new Field($title, $name);
	}

	public function email()
	{
		$this->type = 'email';

		$this->rules = array_merge($this->rules, ['email', 'unique']);
		
		return $this;
	}

	public function date()
	{
		$this->type = 'date';

		return $this;
	}

	public function decimal()
	{
		$this->type = 'number';

		$this->step = 0.01;

		$this->rules[] = ['decimal'];

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
				'label' => $case->name,
			];
		}
		
		$this->additional_data['options'] = $options;

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
		$key = array_search('required', $this->rules);
		
		if($key !== false)
		{
			unset($this->rules[$key]);

			$this->rules[] = 'nullable';
		}

		return $this;
	}
}