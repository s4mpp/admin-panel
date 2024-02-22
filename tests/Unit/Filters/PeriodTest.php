<?php

namespace S4mpp\AdminPanel\Tests\Unit\CustomActions;

use S4mpp\AdminPanel\Filter\Period;
use S4mpp\AdminPanel\Tests\TestCase;

final class PeriodTest extends TestCase
{
    public function test_create_period(): void
    {
        $card = new Period('Date', 'created_at');

        $this->assertSame('Date', $card->getTitle());
        $this->assertSame('created_at', $card->getField());
    }
}
