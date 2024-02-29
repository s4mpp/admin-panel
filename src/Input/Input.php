<?php

namespace S4mpp\AdminPanel\Input;

use Illuminate\Contracts\View\View;
use S4mpp\AdminPanel\Traits\Titleable;
use S4mpp\AdminPanel\Traits\HasDefaultText;
use S4mpp\AdminPanel\Traits\HasValidationRules;
use Illuminate\Contracts\View\Factory as ViewFactory;

abstract class Input
{
    use HasDefaultText, Titleable;

    private ?string $prefix = 'data';

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

    // public function prefix(string $prefix): self
    // {
    //     $this->prefix = $prefix;

    //     return $this;
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
}
