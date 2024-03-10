<?php

namespace S4mpp\AdminPanel\Labels;

use Illuminate\Contracts\View\View;

final class File extends Label
{
    protected string $component = 'admin::labels.file';

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
