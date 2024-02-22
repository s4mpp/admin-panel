<?php

namespace S4mpp\AdminPanel\Tests\Unit\CustomActions;

use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\CustomActions\Update;

final class UpdateTest extends TestCase
{
    public function test_create_update(): void
    {
        $update = new Update('Update Action', []);

        $this->assertSame('Update Action', $update->getTitle());

        $this->assertSame('#', $update->getUrl());
    }
}
