<?php

namespace S4mpp\AdminPanel\Tests\Unit\CustomActions;

use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\CustomActions\Link;

final class LinkTest extends TestCase
{
    public function test_create_link(): void
    {
        $link = new Link('Link', 'https://www.example.com');

        $this->assertSame('Link', $link->getTitle());
        $this->assertSame('https://www.example.com', $link->getUrl());
    }
}
