<?php

namespace S4mpp\AdminPanel\Labels;

use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View as View;

final class Badge extends Label
{
    // public function render($value, $sequence)
    // {
    // 	return view('admin::label.badge', compact('value', 'sequence'));
    // }

    public function showContent(string $content = null): string|View|ViewFactory
    {
        return view('admin::labels.badge', compact('content'));
    }
}
