<?php

namespace S4mpp\AdminPanel\Labels;

use Illuminate\Contracts\View\View;

final class MarkDown extends Label
{
    // public function render($value, $sequence)
    // {
    // 	return view('admin::label.markdown', compact('value'));
    // }

    public function showContent(mixed $content = null): mixed
    {
        return view('admin::labels.markdown', compact('content'));
    }
}
