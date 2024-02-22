<?php

namespace S4mpp\AdminPanel\Labels;

use Illuminate\Contracts\View\View;
use S4mpp\AdminPanel\Traits\Titleable;
use S4mpp\AdminPanel\Traits\Strongable;

abstract class Label
{
    use Titleable;    

    private ?string $alignment = 'left';

    public function __construct(private string $title, private string $field)
    {
    }    

    public function getField(): ?string
    {
        return $this->field;
    }

    public function align(string $alignment): self
    {
        $this->alignment = in_array($alignment, ['left', 'center', 'right']) ? $alignment : null;

        return $this;
    }

    public function getAlignment(): ?string
    {
        return $this->alignment;
    }

    // public function renderItemView($content = null)
    // {
    // 	return view('admin::labels.read-label', ['item' => $this, 'content' => $content]);
    // }

    public function showContent(mixed $content = null): mixed
    {
        return $content;
    }
}
