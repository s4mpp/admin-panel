<?php

namespace S4mpp\AdminPanel\Tests\Unit\Elements;

use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\Elements\Repeater;

final class RepeaterTest extends TestCase
{
    public function test_create_repeater(): void
    {
        $repeater = new Repeater('Repeater title', 'relation');

        $this->assertSame('repeater-title', $repeater->getSlug());
        $this->assertSame('Repeater title', $repeater->getTitle());
        $this->assertSame('relation', $repeater->getRelation());

        $this->assertFalse($repeater->canEdit());
        $this->assertFalse($repeater->canAdd());

        $this->assertIsArray($repeater->getColumns());
        $this->assertEmpty($repeater->getColumns());

        $this->assertIsArray($repeater->getForm());
        $this->assertEmpty($repeater->getForm());
    }

    public function test_allow_edit(): void
    {
        $repeater = new Repeater('Repeater title', 'relation');

        $repeater->allowEdit();

        $this->assertTrue($repeater->canEdit());
        $this->assertFalse($repeater->canAdd());
    }

    public function test_allow_add(): void
    {
        $repeater = new Repeater('Repeater title', 'relation');

        $repeater->allowAdd();

        $this->assertTrue($repeater->canAdd());
        $this->assertFalse($repeater->canEdit());
    }

    public function test_ordenation(): void
    {
        $repeater = new Repeater('Repeater title', 'relation');

        $repeater->orderBy('name', 'asc');

        $this->assertEquals('name', $repeater->getOrdenationField());
        $this->assertEquals('asc', $repeater->getOrdenationDirection());
    }
}
