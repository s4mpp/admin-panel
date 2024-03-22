<?php

namespace S4mpp\AdminPanel\Tests\Unit\Labels;

use S4mpp\AdminPanel\Labels\Text;
use S4mpp\AdminPanel\Tests\TestCase;

final class LabelTest extends TestCase
{
    public function test_create_instance(): void
    {
        $label = new Text('Title', 'field');

        $this->assertFalse($label->isRelationship());
        
        $this->assertSame('field', $label->getField());
    }

    public function test_align(): void
    {
        $label = new Text('Title', 'field');

        $label->align('left');

        $this->assertSame('left', $label->getAlignment());
    }

    public function test_relationship(): void
    {
        $label = new Text('Title', 'field');

        $label->relationShip();

        $this->assertTrue($label->isRelationship());
    }

    public function test_relationship_auto_by_name(): void
    {
        $label = new Text('Title', 'field.name');

        $this->assertTrue($label->isRelationship());
    }
}
