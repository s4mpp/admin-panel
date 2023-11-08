<?php

namespace S4mpp\AdminPanel\Elements;

use S4mpp\Format\Format;
use S4mpp\AdminPanel\Traits\HasLabel;
use S4mpp\AdminPanel\Traits\HasDefaultText;
use Illuminate\Database\Eloquent\Collection;
use S4mpp\AdminPanel\Traits\HasType;

class Field
{
	use HasDefaultText, HasType;
	
	private array $rules = ['required'];

	private array $additional_data = [];
		
	private $prepare_for_validation = null;

	private $prefix = 'data';

	function __construct(private string $title, private string $name)
	{}

	public static function create(string $title, string $name)
	{
		return new Field($title, $name);
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function render($resource = null)
	{
		return view('admin::elements.field', ['field' => $this, 'resource' => $resource]);
	}

	public function renderInput($resource = null)
	{
		return view('admin::elements.input', ['field' => $this, 'resource' => $resource]);
	}

	public function isRequired(): bool
	{
		return in_array('required', $this->getRules());
	}

	public function setPrefix(string $prefix)
	{
		$this->prefix = $prefix;

		return $this;
	}

	public function getPrefix(): string
	{
		return $this->prefix;
	}

	public function prepareForValidation(callable $callback)
	{
		$this->prepare_for_validation = $callback;
	}

	public function getPrepareForValidation()
	{
		return $this->prepare_for_validation;
	}

	public function getRules(): array
	{
		return $this->rules;
	}

	public function getAdditionalData(string $key)
	{
		return $this->additional_data[$key] ?? null;
	}

	public function rules(string ...$rules)
	{
		foreach($rules as $rule)
		{
			$this->rules[] = $rule;
		}

		return $this;
	}

	public function email()
	{
		$this->type = 'email';

		$this->rules[] = 'email';
		
		return $this;
	}

	public function file()
	{
		$this->type = 'file';

		$this->rules[] = 'file';
		
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

	public function textarea(int $rows = 4)
	{
		$this->type = 'textarea';
		
		$this->additional_data['rows'] = $rows;

		return $this;
	}

	public function currency(bool $has_cents = false)
	{
		$this->type = 'currency';

		$this->prepare_for_validation = function(string $value = null) use ($has_cents)
		{
			if(is_null($value) || !$value)
			{
				return null;
			}

			$nb_float = Format::numberToFloat($value);

			if($has_cents)
			{
				return intval($nb_float * 100);
			}

			return $nb_float;
		};

		$this->rules = ($has_cents)
		? array_merge($this->rules, ['integer', 'min:1', 'max:21000000'])
		: array_merge($this->rules, ['numeric', 'min:0.01', 'max:21000000.00']);
		
		$this->_removeRule('string');

		$this->additional_data['has_cents'] = $has_cents;

		return $this;
	}

	public function decimal()
	{
		$this->type = 'number';

		$this->additional_data['step'] = 0.01;

		$this->_removeRule('string');

		$this->rules[] = 'numeric';

		return $this;
	}

	public function integer()
	{
		$this->type = 'number';

		$this->additional_data['step'] = 1;

		$this->_removeRule('string');
		
		$this->rules[] = 'integer';

		return $this;
	}

	public function min(float $min)
	{
		$this->additional_data['min'] = $min;

		$this->rules[] = 'min:'.$min;

		return $this;
	}

	public function max(float $max)
	{
		$this->additional_data['max'] = $max;

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

		$ids = [];

		foreach($cases as $case)
		{
			$ids[] = $id = $case->value;

			$options[] = [
				'id' => $id,
				'label' => (method_exists($case, 'label')) ? $case->label() : $case->name,
			];
		}

		$this->rules('in:'.join(',', $ids));
		
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

	public function relation(Collection $model_options, string $fk_relation, string $fk_field = null)
	{
		$this->_removeRule('string');
		$this->rules[] = 'integer';

		$this->type = 'select';

		$options = [];

		foreach($model_options as $model_item)
		{
			$label = collect($model_item)->get($fk_relation);

			if($fk_field)
			{
				$label = $label[$fk_field];
			}

			$options[] = [
				'id' => $model_item->id,
				'label' =>$label,
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