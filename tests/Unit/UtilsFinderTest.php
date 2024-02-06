<?php

namespace S4mpp\AdminPanel\Tests\Unit;

use S4mpp\Laraguard\Utils;
use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Utils\Finder;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\Factories\Label;
use S4mpp\AdminPanel\Factories\Filter;
use S4mpp\AdminPanel\CustomActions\CustomAction;
use S4mpp\AdminPanel\Factories\CustomAction as CustomActionFactory;

class UtilsFinderTest extends TestCase
{
	public function test_only_of()
	{
		$array = [
			CustomActionFactory::link('Test', 'https://test.com'),
			Filter::period('Created at', 'created_at'),
			Label::text('Title', 'title'),
		];

		$array_filtered = Finder::onlyOf($array, CustomAction::class);

		$this->assertIsArray($array_filtered);
		$this->assertCount(1, $array_filtered);
	}
}