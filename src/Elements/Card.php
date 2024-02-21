<?php

namespace S4mpp\AdminPanel\Elements;

use S4mpp\AdminPanel\Input\Input;
use S4mpp\AdminPanel\Labels\Label;
use S4mpp\AdminPanel\Traits\Titleable;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View as View;

final class Card
{
    use Titleable;

    /**
     * @param array<Input|Label> $elements
     */
    public function __construct(private string $title, private array $elements = [])
    {
    }

    /**
     * @return array<Input|Label>
     */
    public function getElements(): array
    {
        return $this->elements;
    }

    public function render(): View|ViewFactory
    {
        return view('admin::elements.card', ['card' => $this]);
    }

    public function addElement(Input|Label $element): self
    {
        $this->elements[] = $element;

        return $this;
    }
}
