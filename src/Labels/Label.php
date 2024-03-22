<?php

namespace S4mpp\AdminPanel\Labels;

use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use S4mpp\AdminPanel\Traits\Titleable;
use Illuminate\Database\Eloquent\Model;
use S4mpp\AdminPanel\Traits\HasCallbacks;

abstract class Label
{
    use HasCallbacks, Titleable;

    private ?string $alignment = 'left';

    private bool $is_relationship = false;

    public function __construct(private string $title, private string $field)
    {
        if (mb_strpos($field, '.') !== false) {
            $this->relationShip();
        }
    }

    public function isRelationShip(): bool
    {
        return $this->is_relationship;
    }

    public function relationShip(bool $value = true): self
    {
        $this->is_relationship = $value;

        return $this;
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

    /**
     * @param  Model|Collection|array<mixed>  $register
     */
    public function getContent(Model|Collection|array $register): mixed
    {
        if ($this->is_relationship) {
            $path = explode('.', $this->getField() ?? '');

            $content = $register[$path[0]] ?? null;

            array_shift($path);

            foreach ($path as $node) {
                $content = $content[$node];
            }
        } else {
            $content = $register[$this->getField()] ?? null;
        }

        if ($this->hasCallbacks()) {
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
