<?php

namespace S4mpp\AdminPanel\Labels;

use Illuminate\Contracts\View\View;

final class LongText extends Label
{
    // public function render($value, $sequence)
    // {
    // 	return view('admin::label.longtext', compact('value'));
    // }

    public function showContent(mixed $content = null): mixed
    {
        return view('admin::labels.longtext', compact('content'));
    }
}
