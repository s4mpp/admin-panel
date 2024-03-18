<?php

namespace S4mpp\AdminPanel\Labels;

use Illuminate\Contracts\View\View;
use S4mpp\AdminPanel\Traits\HasComponent;
use S4mpp\AdminPanel\Traits\Strongable;

final class MarkDown extends Label
{
    use Strongable, HasComponent;

    /**
     *
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
