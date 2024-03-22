<?php

namespace S4mpp\AdminPanel\Labels;

use Illuminate\Contracts\View\View;
use S4mpp\AdminPanel\Traits\HasComponent;

final class Badge extends Label
{
    use HasComponent;

    /**
     * @var string|array<string>
     */
    protected string|array $component = 'admin::labels.badge';

    // public function render($value, $sequence)
    // {
    // 	return view('admin::label.badge', compact('value', 'sequence'));
    // }

    // public function showContent(mixed $content = null): mixed
    // {
    //     return view('admin::labels.badge', compact('content'));
    // }
}
