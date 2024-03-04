<?php

namespace S4mpp\AdminPanel\Tests\Unit\CustomActions;

use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\CustomActions\Callback;

final class CallbackTest extends TestCase
{
    public function test_create_callback(): void
    {
        $callback = new Callback('Callback Action', function (): void {});

        $this->assertSame('Callback Action', $callback->getTitle());
    }

    public function test_get_callback(): void
    {
        $callback = new Callback('Callback Action', function (): void {});

        $this->assertIsCallable($callback->getCallback());
    }
}
