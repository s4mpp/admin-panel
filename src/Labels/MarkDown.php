<?php

namespace S4mpp\AdminPanel\Labels;

use Illuminate\Contracts\View\View;
use S4mpp\AdminPanel\Traits\Strongable;

final class MarkDown extends Label
{
    use Strongable;

    // public function render($value, $sequence)
    // {
    // 	return view('admin::label.markdown', compact('value'));
    // }

    public function showContent(mixed $content = null): mixed
    {
        return view('admin::labels.markdown', compact('content'));
    }
}
