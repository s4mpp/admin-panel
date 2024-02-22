<?php

namespace S4mpp\AdminPanel\Tests\Unit\Traits;

use S4mpp\AdminPanel\Input\Text;
use S4mpp\AdminPanel\Filter\Period;
use S4mpp\AdminPanel\Tests\TestCase;

final class TitleableTest extends TestCase
{
    public static function titleablesProvider()
    {
        return [
            'input text' => [new Text('title', 'field')],
            'filter period' => [new Period('title', 'field')],
        ];
    }

    /**
     * @dataProvider titleablesProvider
     */
    public function test_get_instance_as_string($titleable): void
    {
        $instance = $titleable;

        $this->assertIsString((string) $instance);
        $this->assertIsString($instance->getTitle());
    }
}
