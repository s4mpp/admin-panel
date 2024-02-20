<?php

namespace S4mpp\AdminPanel\Tests\Unit\CustomActions;

use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\Elements\Repeater;

class RepeaterTest extends TestCase
{
	public function test_create_repeater()
	{
		$repeater = new Repeater('Repeater title', 'relation');

		$this->assertSame('repeater-title', $repeater->getSlug());
		$this->assertSame('Repeater title', $repeater->getTitle());
		$this->assertSame('relation', $repeater->getRelation());
		
		$this->assertFalse($repeater->canEdit());
		$this->assertFalse($repeater->canAdd());

		$this->assertIsArray($repeater->getColumns());
		$this->assertEmpty($repeater->getColumns());

		$this->assertIsArray($repeater->getColumnsWithActions());
		$this->assertEmpty($repeater->getColumnsWithActions());
	}

	public function test_allow_edit()
	{
		$repeater = new Repeater('Repeater title', 'relation');

		$repeater->allowEdit();
		
		$this->assertTrue($repeater->canEdit());
		$this->assertFalse($repeater->canAdd());
	}

	public function test_allow_add()
	{
		$repeater = new Repeater('Repeater title', 'relation');

		$repeater->allowAdd();

		$this->assertTrue($repeater->canAdd());
		$this->assertFalse($repeater->canEdit());
	}
}