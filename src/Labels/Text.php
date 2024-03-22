<?php

namespace S4mpp\AdminPanel\Labels;

use S4mpp\AdminPanel\Traits\Strongable;
use S4mpp\AdminPanel\Traits\HasComponent;

final class Text extends Label
{
    use HasComponent, Strongable;

    /**
     * @var string|array<string>
     */
    protected string|array $component = [];

    // public function showContent(mixed $content = null, $register): mixed
    // {
    //     if($this->hasCallback())
    //     {
    //         $content = $this->runCallbacks($content, $register);
    //     }

    //     return $content;
    // }
}
