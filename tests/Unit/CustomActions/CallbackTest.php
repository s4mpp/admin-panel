<?php

namespace S4mpp\AdminPanel\Tests\Unit\CustomActions;

use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\CustomActions\Callback;

final class CallbackTest extends TestCase
{
    public function test_create_callback(): void
    {
        $link = new Callback('Callback Action', function (): void {
        });

        $this->assertSame('Callback Action', $link->getTitle());

        $this->assertSame('#', $link->getUrl());
    }
}
