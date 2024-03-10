<?php

namespace S4mpp\AdminPanel\Labels;

use Illuminate\Contracts\View\View;

final class Badge extends Label
{
    protected string $component = 'admin::labels.badge';

    // public function render($value, $sequence)
    // {
    // 	return view('admin::label.badge', compact('value', 'sequence'));
    // }

    // public function showContent(mixed $content = null): mixed
    // {
    //     return view('admin::labels.badge', compact('content'));
    // }
}
