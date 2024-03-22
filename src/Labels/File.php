<?php

namespace S4mpp\AdminPanel\Labels;

use Illuminate\Contracts\View\View;
use S4mpp\AdminPanel\Traits\HasComponent;

final class File extends Label
{
    use HasComponent;

    /**
     * @var string|array<string>
     */
    protected string|array $component = 'admin::labels.file';

    // public function renderView($value)
    // {
    // 	$item = $this;

    // 	return view('admin::label.file', compact('value', 'item'));
    // }

    // public function showContent(mixed $content = null): mixed
    // {
    //     return view('admin::labels.file', compact('content'));
    // }
}
