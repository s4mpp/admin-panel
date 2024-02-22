<?php

namespace S4mpp\AdminPanel\Tests\Unit\CustomActions;

use S4mpp\AdminPanel\Input\Text;
use S4mpp\AdminPanel\Tests\TestCase;

final class TextTest extends TestCase
{
    public function test_mask(): void
    {
        $text = new Text('Title', 'field');

        $text->mask('9999');

        $this->assertSame('9999', $text->getMask());
    }
}
