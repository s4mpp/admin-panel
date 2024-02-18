<?php

namespace S4mpp\AdminPanel\Tests\Unit;

use S4mpp\Laraguard\Utils;
use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Input\Input;
use S4mpp\AdminPanel\Labels\Label;
use S4mpp\AdminPanel\Utils\Finder;
use S4mpp\AdminPanel\Filter\Filter;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\CustomActions\CustomAction;
use S4mpp\AdminPanel\CustomActions\Link;
use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Factories\Input as InputFactory;
use S4mpp\AdminPanel\Factories\Label as LabelFactory;
use S4mpp\AdminPanel\Factories\Filter as FilterFactory;
use S4mpp\AdminPanel\Factories\CustomAction as CustomActionFactory;
use S4mpp\AdminPanel\Filter\Period;
use S4mpp\AdminPanel\Input\Textarea;
use S4mpp\AdminPanel\Labels\Text;

class FinderTest extends TestCase
{
	public static function finderClassProvider()
	{
		return [
			'null value' => [[null], 0, []],
			'1 subclasses' => [[Period::class], 1, [1]],
			'0 subclasses' => [[], 0, []],
			'3 subclasses' => [[Link::class, Textarea::class, Text::class], 3, [0,2,3]],
			'all subclasses' => [[Link::class, Period::class, Textarea::class, Text::class], 4, [0,1,2,3]],
			'subclasses repeat' => [[Link::class, Link::class], 1, [0]],
			'1 classes' => [[Filter::class], 1, [1]],
			'0 classess' => [[], 0, []],
			'3 classess' => [[CustomAction::class, Label::class, Input::class], 3, [0,2,3]],
			'all classess' => [[CustomAction::class, Filter::class, Label::class, Input::class], 4, [0,1,2,3]],
			'classes repeat' => [[CustomAction::class, CustomAction::class], 1, [0]],
			'classes excluded' => [[CustomAction::class, Card::class], 1, [0]],
		];
	}

	/**
	 * 
	 * @dataProvider finderClassProvider
	 */
	public function test_only_of($elements_to_find = null, int $expected_quantity, array $keys_expected)
	{
		$array = [
			0 => CustomActionFactory::link('Test', 'https://test.com'),
			1 => FilterFactory::period('Created at', 'created_at'),
			2 => LabelFactory::text('Title', 'title'),
			3 => InputFactory::textarea('Title', 'title'),
		];

		$array_filtered = Finder::onlyOf($array, ...$elements_to_find); 

		$array_like_expected = array_values(array_filter($array, function($key) use ($keys_expected)
		{
			return in_array($key, $keys_expected);
			
		}, ARRAY_FILTER_USE_KEY));
		
		$this->assertIsArray($array_filtered);
		$this->assertCount($expected_quantity, $array_filtered);

		$this->assertEquals($array_like_expected, $array_filtered);
	}
}