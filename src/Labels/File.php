<?php

namespace S4mpp\AdminPanel\Labels;

use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View as View;

final class File extends Label
{
    // public function renderView($value)
    // {
    // 	$item = $this;

    // 	return view('admin::label.file', compact('value', 'item'));
    // }

    public function showContent(string $content = null): string|View|ViewFactory
    {
        return view('admin::labels.file', compact('content'));
    }
}
