<?php

namespace S4mpp\AdminPanel\Input;

use Closure;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;
use S4mpp\AdminPanel\Traits\Titleable;
use S4mpp\AdminPanel\Traits\HasDefaultText;
use Illuminate\Contracts\View\Factory as ViewFactory;

abstract class Input
{
    // use HasDefaultText,
    use HasDefaultText, Titleable;

    private ?string $prefix = 'data';

    /**
     * @var array<string|Rule>
     */
    private array $rules = ['required'];

    private ?Closure $prepare_for_form = null;

    // private $prepare_for_save = null;

    private ?string $description = null;

    public function __construct(private string $title, private string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getNameWithPrefix(): string
    {
        return implode('.', array_filter([$this->prefix, $this->name]));
    }

    public function description(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function prefix(string $prefix): self
    {
        $this->prefix = $prefix;

        return $this;
    }

    // public function unique()
    // {
    // 	$this->rules('unique');

    // 	return $this;
    // }

    public function getView(): ?string
    {
        return $this->view ?? null;
    }

    public function render(): View|ViewFactory
    {
        return view('admin::input.field', [
            'input' => $this,
            // 'register' => $register,
            // 'data' => $data,
        ]);
    }

    public function isRequired(): bool
    {
        return in_array('required', $this->rules);
    }

    // public function prepareForSave(callable $callback)
    // {
    // 	$this->prepare_for_save = $callback;

    // 	return $this;
    // }

    // public function getPrepareForSave()
    // {
    // 	return $this->prepare_for_save;
    // }

    public function prepareForForm(callable $callback): self
    {
        $this->prepare_for_form = $callback;

        return $this;
    }

    public function getPrepareForForm(): callable
    {
        return $this->prepare_for_form;
    }

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

    public function rules(string ...$rules): self
    {
        foreach ($rules as $rule) {
            $this->rules[] = $rule;
        }

        return $this;
    }

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
