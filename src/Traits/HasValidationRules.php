<?php

namespace S4mpp\AdminPanel\Traits;

use Closure;
use Illuminate\Validation\Rule;
use S4mpp\AdminPanel\Input\Input;


trait HasValidationRules
{
    /**
     * @var array<mixed>
     */
    private array $rules = ['required'];

    
    /**
     * @return array<string|Rule>
     */
    public function getValidationRules(Input $input, string $table, int $id = null): array
    {
    	foreach($this->rules as $rule)
    	{
            /** @var object $rule */
    		if(is_a($rule, Closure::class))
            {
                $rule = call_user_func($rule, $input, $table, $id);
            }

            $rules[] = $rule;
    	}

    	return $rules ?? [];
    }

    public function addRule(string|Closure ...$rules): self
    {
        foreach ($rules as $rule) {
            $this->rules[] = $rule;
        }

        return $this;
    }

    public function removeRule(string $rule): void
    {
    	$key = array_search($rule, $this->rules);

    	if($key !== false)
    	{
    		unset($this->rules[$key]);
    	}
    }

    public function isRequired(): bool
    {
        return in_array('required', $this->rules);
    }

    public function notRequired(): self
    {
    	$this->removeRule('required');

    	$this->addRule('nullable');

    	return $this;
    }

    public function unique(): self
    {
    	$this->addRule(function(Input $input, string $table, int $id = null) {
            return Rule::unique($table, $input->getName())->ignore($id);
        });

    	return $this;
    }
}
