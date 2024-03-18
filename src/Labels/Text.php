<?php

namespace S4mpp\AdminPanel\Labels;

use S4mpp\AdminPanel\Traits\HasComponent;
use S4mpp\AdminPanel\Traits\Strongable;

final class Text extends Label
{
    use Strongable, HasComponent;

    /**
     *
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
