<?php

namespace S4mpp\AdminPanel\Labels;

use Illuminate\Contracts\View\View;
use S4mpp\AdminPanel\Traits\Strongable;

final class LongText extends Label
{
    use Strongable;

    protected string $component = 'admin::label.longtext';

    // public function render($value, $sequence)
    // {
    // 	return view('admin::label.longtext', compact('value'));
    // }

    // public function showContent(mixed $content = null): mixed
    // {
    //     return view('admin::labels.longtext', compact('content'));
    // }
}
