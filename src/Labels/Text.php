<?php

namespace S4mpp\AdminPanel\Labels;

use S4mpp\AdminPanel\Traits\Strongable;
use S4mpp\AdminPanel\Traits\HasCallbacks;

final class Text extends Label
{
    use Strongable;

    // public function showContent(mixed $content = null, $register): mixed
    // {
    //     if($this->hasCallback())
    //     {
    //         $content = $this->runCallbacks($content, $register);
    //     }

    //     return $content;
    // }
}
