<?php

namespace S4mpp\AdminPanel\Labels;

use Illuminate\Support\Carbon;
use Illuminate\Contracts\View\View;
use S4mpp\AdminPanel\Traits\Strongable;
use S4mpp\AdminPanel\Traits\HasComponent;

final class Datetime extends Label
{
    use HasComponent, Strongable;

    /**
     * @var string|array<string>
     */
    protected string|array $component = 'admin::label.datetime';

    public function __construct(string $title, string $field, private string $format)
    {
        parent::__construct($title, $field);
    }

    public function getDateTimeFormatted(Carbon|string|null $datetime = null): mixed
    {
        /** @var object $datetime */
        if (is_a($datetime, Carbon::class)) {
            return $datetime->format($this->format);
        }
        
        return $datetime;
    }
    
    public function getDiffForHumans(Carbon|string|null $datetime = null): ?string
    {
        /** @var object $datetime */
        if (is_a($datetime, Carbon::class)) {
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
