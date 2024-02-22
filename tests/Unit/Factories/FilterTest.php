<?php

namespace S4mpp\AdminPanel\Tests\Unit\Factories;

use S4mpp\AdminPanel\Filter\Period;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\Factories\Filter;

final class FilterTest extends TestCase
{
    public function test_factory_period(): void
    {
        $input = Filter::period('title', 'field');

        $this->assertInstanceOf(Period::class, $input);
    }
}
