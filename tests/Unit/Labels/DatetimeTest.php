<?php

namespace S4mpp\AdminPanel\Tests\Unit\Labels;

use Illuminate\View\View;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\Labels\Datetime;

final class DatetimeTest extends TestCase
{
    public function test_show_content(): void
    {
        $datetime = new Datetime('Title', 'field', 'Y-m-d H:i:s');

        $this->assertInstanceOf(View::class, $datetime->showContent('x'));
    }
}
