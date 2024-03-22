<?php

namespace S4mpp\AdminPanel\Labels;

use Illuminate\Contracts\View\View;
use S4mpp\AdminPanel\Traits\Strongable;
use S4mpp\AdminPanel\Traits\HasComponent;

final class MarkDown extends Label
{
    use HasComponent, Strongable;

    /**
     * @var string|array<string>
     */
    protected string|array $component = 'admin::label.markdown';

    // public function render($value, $sequence)
    // {
    // 	return view('admin::label.markdown', compact('value'));
    // }

    // public function showContent(mixed $content = null): mixed
    // {
    //     return view('admin::labels.markdown', compact('content'));
    // }
}
