<?php

namespace S4mpp\AdminPanel\Labels;

use S4mpp\AdminPanel\Traits\Titleable;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View as View;

abstract class Label
{
    use Titleable;

    private bool $strong = false;

    private ?string $alignment = 'left';

    public function __construct(private string $title, private string $field)
    {
    }

    public function strong(): self
    {
        $this->strong = true;

        return $this;
    }

    public function getIsStrong(): bool
    {
        return $this->strong;
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

    public function showContent(string $content = null): string|View|ViewFactory
    {
        return $content;
    }
}
