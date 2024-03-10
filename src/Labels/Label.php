<?php

namespace S4mpp\AdminPanel\Labels;

use Illuminate\Contracts\View\View;
use S4mpp\AdminPanel\Traits\Titleable;
use Illuminate\Database\Eloquent\Model;
use S4mpp\AdminPanel\Traits\HasCallback;
use S4mpp\AdminPanel\Traits\HasCallbacks;
use S4mpp\AdminPanel\Traits\HasComponent;

abstract class Label
{
    use Titleable, HasComponent, HasCallbacks;

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

    public function getContent(Model $register): mixed
    {
        $content =  $register[$this->getField()] ?? null;

        if($this->hasCallbacks())
        {
            $content = $this->runCallbacks($content, $register);
        }

        return $content;
    }

    // public function renderItemView($content = null)
    // {
    // 	return view('admin::labels.read-label', ['item' => $this, 'content' => $content]);
    // }

    // public function showContent(mixed $content = null, $register): mixed
    // {
    //     return $content;
    // }
}
