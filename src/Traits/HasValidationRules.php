<?php

namespace S4mpp\AdminPanel\Traits;

use Closure;
use Illuminate\Validation\Rule;

trait HasValidationRules
{
    /**
     * @var array<mixed>
     */
    private array $rules = ['required'];

    /**
     * @return array<string|Rule>
     *
     * @todo change name and context to "EXECUTE RULE". this function do not return rules
     */
    public function getRules(string $table = '', ?int $id = null): array
    {
        foreach ($this->rules as $rule) {
            if (is_callable($rule)) {
                $rule = call_user_func($rule, $table, $id);
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

        if ($key !== false) {
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
        $this->addRule(fn (string $table, ?int $id = null) => Rule::unique($table, $this->getName())->ignore($id));

        return $this;
    }
}
