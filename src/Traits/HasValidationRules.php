<?php

namespace S4mpp\AdminPanel\Traits;

use Illuminate\Validation\Rule;

trait HasValidationRules
{
    /**
     * @var array<string|Rule>
     */
    private array $rules = ['required'];

	public function isRequired(): bool
    {
        return in_array('required', $this->rules);
    }

	public function rules(string ...$rules): self
    {
        foreach ($rules as $rule) {
            $this->rules[] = $rule;
        }

        return $this;
    }

	// public function unique()
    // {
    // 	$this->rules('unique');

    // 	return $this;
    // }

	// public function getRules(string $table, int $register_id = null): array
    // {
    // 	foreach($this->rules as $rule)
    // 	{
    // 		switch($rule)
    // 		{
    // 			case 'unique':
    // 				$rules[] = Rule::unique($table)->ignore($register_id);
    // 				break;

    // 			default:
    // 				$rules[] = $rule;
    // 		}
    // 	}

    // 	return $rules ?? [];
    // }


	// public function notRequired()
    // {
    // 	$this->_removeRule('required');

    // 	$this->rules('nullable');

    // 	return $this;
    // }

    // private function _removeRule(string $rule)
    // {
    // 	$key = array_search($rule, $this->rules);

    // 	if($key !== false)
    // 	{
    // 		unset($this->rules[$key]);
    // 	}
    // }
}
