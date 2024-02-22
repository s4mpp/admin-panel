<?php

namespace S4mpp\AdminPanel\Tests\Unit\Labels;

use S4mpp\AdminPanel\Labels\Text;
use S4mpp\AdminPanel\Tests\TestCase;

final class LabelTest extends TestCase
{
    public function test_align(): void
    {
        $label = new Text('Title', 'field');

        $label->align('left');

        $this->assertSame('left', $label->getAlignment());
    }
}
