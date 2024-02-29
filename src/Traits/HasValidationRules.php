<?php

namespace S4mpp\AdminPanel\Traits;

use Closure;
use Illuminate\Validation\Rule;
use S4mpp\AdminPanel\Input\Input;


trait HasValidationRules
{
    /**
     * @var array<string|Rule|Closure>
     */
    private array $rules = ['required'];

    
    /**
     * @return array<string|Rule>
     */
    public function getValidationRules(Input $input, string $table, int $id = null): array
    {
    	foreach($this->rules as $rule)
    	{
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

    public function removeRule(string $rule)
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

    public function notRequired()
    {
    	$this->removeRule('required');

    	$this->addRule('nullable');

    	return $this;
    }

    public function unique()
    {
    	$this->addRule(function(Input $input, string $table, int $id = null) {
            return Rule::unique($table, $input->getName())->ignore($id);
        });

    	return $this;
    }
}
