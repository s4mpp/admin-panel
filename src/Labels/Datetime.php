<?php

namespace S4mpp\AdminPanel\Labels;

use Illuminate\Support\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use S4mpp\AdminPanel\Traits\Strongable;

final class Datetime extends Label
{
    use Strongable;

    protected string $component = 'admin::label.datetime';

    public function __construct(string $title, string $field, private string $format)
    {
        parent::__construct($title, $field);
    }

    public function getDateTimeFormatted(Carbon|string|null $datetime = null): mixed
    {        
        if(is_a($datetime, Carbon::class))
        {
            return $datetime->format($this->format);
        }

        return $datetime;
    }

    public function getDiffForHumans(Carbon|string|null $datetime = null)
    {
        if(is_a($datetime, Carbon::class))
        {
            return $datetime->diffForHumans();
        }

        return null;
    }

    // public function render($value, $sequence)
    // {
    // 	$format = $this->format;

    // 	return view('admin::label.datetime', compact('value', 'sequence', 'format'));
    // }

    // public function showContent(mixed $content = null, $register): mixed
    // {
    //     $format = $this->format;

    //     if(is_a($content, Carbon::class))
    //     {
    //         $content = $content?->format($format);
    //     }

    //     return view('admin::labels.datetime', compact('content'));
    // }
}
