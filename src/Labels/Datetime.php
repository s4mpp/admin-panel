<?php

namespace S4mpp\AdminPanel\Labels;

use Illuminate\Contracts\View\View;
use S4mpp\AdminPanel\Traits\Strongable;

final class Datetime extends Label
{
    use Strongable;

    public function __construct(string $title, string $field, private string $format)
    {
        parent::__construct($title, $field);
    }

    // public function render($value, $sequence)
    // {
    // 	$format = $this->format;

    // 	return view('admin::label.datetime', compact('value', 'sequence', 'format'));
    // }

    public function showContent(mixed $content = null): mixed
    {
        $format = $this->format;

        return view('admin::labels.datetime', compact('content', 'format'));
    }
}
