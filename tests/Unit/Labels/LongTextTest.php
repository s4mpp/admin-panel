<?php

namespace S4mpp\AdminPanel\Tests\Unit\Labels;

use Illuminate\View\View;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\Labels\LongText;

final class LongTextTest extends TestCase
{
    public function test_show_content(): void
    {
        $long_Text = new LongText('Title', 'field');

        $this->assertInstanceOf(View::class, $long_Text->showContent('x'));
    }
}
