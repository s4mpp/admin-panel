<?php

namespace S4mpp\AdminPanel\Tests\Unit\Traits;

use S4mpp\AdminPanel\Input\Text;
use S4mpp\AdminPanel\Tests\TestCase;

final class HasDefaultTextTest extends TestCase
{
    public static function hasDefaultTextTestProvider()
    {
        return [
            'input text' => [new Text('Title', 'field')],
        ];
    }

    /**
     * @dataProvider hasDefaultTextTestProvider
     */
    public function test_not_has_default_text($has_default_text): void
    {
        $instance = $has_default_text;

        $this->assertNull($instance->getDefaultText());
    }

    /**
     * @dataProvider hasDefaultTextTestProvider
     */
    public function test_has_default_text($has_default_text): void
    {
        $instance = $has_default_text;

        $instance->default('Default text');

        $this->assertSame('Default text', $instance->getDefaultText());
    }
}
