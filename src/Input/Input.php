<?php

namespace S4mpp\AdminPanel\Input;

use Illuminate\Validation\Rule;
use S4mpp\AdminPanel\Traits\Titleable;
use S4mpp\AdminPanel\Traits\HasDefaultText;

abstract class Input
{
	use HasDefaultText, Titleable;

	private ?string $prefix = 'data';
	
	private array $rules = ['required'];
		
	private $prepare_for_validation = null;

	function __construct(private string $title, private string $name)
	{}

	public function getName(): string
	{
		return $this->name;
	}

	public function getNameWithPrefix(): string
	{
		return join('.', array_filter([$this->prefix, $this->name]));
	}

	public function setPrefix(string $prefix)
	{
		$this->prefix = $prefix;

		return $this;
	}

	public function unique()
	{
		$this->rules('unique');
		
		return $this;
	}

	public function render(array $data, $register = null)
	{
		return view('admin::input.field', [
			'input' => $this,
			'register' => $register,
			'data' => $data,
		]);
	}

	public function isRequired(): bool
	{
		return in_array('required', $this->rules);
	}

	public function prepareForValidation(callable $callback)
	{
		$this->prepare_for_validation = $callback;

		return $this;
	}

	public function getPrepareForValidation()
	{
		return $this->prepare_for_validation;
	}

	public function getRules(string $table, int $register_id = null): array
	{
		foreach($this->rules as $rule)
		{
			switch($rule)
			{
				case 'unique':
					$rules[] = Rule::unique($table)->ignore($register_id);
					break;
					
				default:
					$rules[] = $rule;	
			}
		}
		
		return $rules ?? [];
	}

	public function rules(string ...$rules)
	{
		foreach($rules as $rule)
		{
			$this->rules[] = $rule;
		}

		return $this;
	}

	public function notRequired()
	{
		$this->_removeRule('required');
		
		$this->rules('nullable');

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