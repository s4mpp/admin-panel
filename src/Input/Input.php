<?php

namespace S4mpp\AdminPanel\Input;

use Illuminate\Contracts\View\View;
use S4mpp\AdminPanel\Traits\Titleable;
use S4mpp\AdminPanel\Traits\HasComponent;
use S4mpp\AdminPanel\Traits\HasDefaultText;
use Illuminate\Contracts\View\Factory as ViewFactory;

abstract class Input
{
    use HasComponent, HasDefaultText, Titleable;

    private ?string $prefix = 'data';

    // private $prepare_for_save = null;

    private ?string $description = null;

    /**
     * @var int|array<int>|null
     */
    protected int|array|null $initial_value = null;

    /**
     * @var string|array<string>
     */
    protected string|array $component = 'admin::input.default';

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

    /**
     * @return int|array<int>|null
     */
    public function getInitialValue(): int|array|null
    {
        return $this->initial_value;
    }

    public function processInputData(mixed $data): mixed
    {
        return $data;
    }

    // public function prefix(string $prefix): self
    // {
    //     $this->prefix = $prefix;

    //     return $this;
    // }

    /**
     * @deprecated
     *
     * @todo change to component
     */
    public function render(): View|ViewFactory
    {
        // $input_attributes = [
        //     'wire:model' => $this->getNameWithPrefix(),
        //     'wire:loading.attr' => 'disabled'
        // ];

        // dump($this->getAttributes());
        // $input_attributes =  array_merge($input_attributes, $this->getAttributes());

        return view('admin::input.field', [
            'input' => $this,
            // 'register' => $register,
            // 'data' => $data,
        ]);
    }
}
