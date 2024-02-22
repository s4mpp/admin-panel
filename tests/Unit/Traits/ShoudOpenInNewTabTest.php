<?php

namespace S4mpp\AdminPanel\Tests\Unit\Traits;

use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\CustomActions\Link;

final class ShoudOpenInNewTabTest extends TestCase
{
    public static function shoudOpenInNewTabProvider()
    {
        return [
            'link' => [new Link('Example', 'http://example.com')],
        ];
    }

    /**
     * @dataProvider shoudOpenInNewTabProvider
     */
    public function test_not_in_new_tab($custom_action): void
    {
        $instance = $custom_action;

        $this->assertFalse($instance->isNewTab());
    }

    /**
     * @dataProvider shoudOpenInNewTabProvider
     */
    public function test_change_to_open_in_new_tab($custom_action): void
    {
        $instance = $custom_action;

        $instance->newTab();

        $this->assertTrue($instance->isNewTab());
    }
}
