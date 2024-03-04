<?php

namespace S4mpp\AdminPanel\Tests\Unit;

use S4mpp\AdminPanel\Input\Input;
use S4mpp\AdminPanel\Labels\Text;
use S4mpp\AdminPanel\Input\Number;
use S4mpp\AdminPanel\Labels\Label;
use S4mpp\AdminPanel\Utils\Finder;
use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Filter\Filter;
use S4mpp\AdminPanel\Filter\Period;
use S4mpp\AdminPanel\Input\Textarea;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\Elements\Repeater;
use S4mpp\AdminPanel\CustomActions\Link;
use S4mpp\AdminPanel\Resources\Resource;
use S4mpp\AdminPanel\CustomActions\CustomAction;
use S4mpp\AdminPanel\Factories\Input as InputFactory;
use S4mpp\AdminPanel\Factories\Label as LabelFactory;
use S4mpp\AdminPanel\Factories\Filter as FilterFactory;
use S4mpp\AdminPanel\Factories\CustomAction as CustomActionFactory;
use S4mpp\AdminPanel\Reports\Report;

final class FinderTest extends TestCase
{
    public static function finderClassProvider()
    {
        return [
            'null value' => [[null], 0, []],
            '1 subclasses' => [[Period::class], 1, [1]],
            '0 subclasses' => [[], 0, []],
            '3 subclasses' => [[Link::class, Textarea::class, Text::class], 3, [0, 2, 3]],
            'all subclasses' => [[Link::class, Period::class, Textarea::class, Text::class], 4, [0, 1, 2, 3]],
            'subclasses repeat' => [[Link::class, Link::class], 1, [0]],
            '1 classes' => [[Filter::class], 1, [1]],
            '0 classess' => [[], 0, []],
            '3 classess' => [[CustomAction::class, Label::class, Input::class], 3, [0, 2, 3]],
            'all classess' => [[CustomAction::class, Filter::class, Label::class, Input::class], 4, [0, 1, 2, 3]],
            'classes repeat' => [[CustomAction::class, CustomAction::class], 1, [0]],
            'classes excluded' => [[CustomAction::class, Link::class], 1, [0]],
        ];
    }

    public static function finderElementProvider()
    {
        return [
            [CustomAction::class, 1],
            [Filter::class, 1],
            [Label::class, 3],
            [Link::class, 1],
            [Label::class, 3],
            [Textarea::class, 1],
            [Number::class, 0],
            [Card::class, 1],
        ];
    }

    public static function slugElementProvider()
    {
        return [
            'normal' => [[new Repeater('Test slug name', 'xxx'), new Report('Other slug name', [])], 'test-slug-name',  Repeater::class, 'test-slug-name'],
            'not found' => [[new Repeater('Test slug name', 'xxx'), new Report('Other slug name', [])], 'xxxxxxxx', null, null],
        ];
    }

    /**
     * @dataProvider slugElementProvider
     */
    public function test_find_by_slug(array $array_of_sluggables, string $slug_to_find, mixed $instance_expected = null, string $slug_expected = null)
    {
        $test = Finder::findBySlug($array_of_sluggables, $slug_to_find);
        
        $this->assertSame($slug_expected, $test?->getSlug());
        
        if(!is_null($instance_expected))
        {
            $this->assertInstanceOf($instance_expected, $test);
        }
    }

    /**
     * @dataProvider finderClassProvider
     */
    public function test_only_of($elements_to_find, int $expected_quantity, array $keys_expected): void
    {
        $array = [
            0 => CustomActionFactory::link('Test', 'https://test.com'),
            1 => FilterFactory::period('Created at', 'created_at'),
            2 => LabelFactory::text('Title', 'title'),
            3 => InputFactory::textarea('Title', 'title'),
        ];

        $array_filtered = Finder::onlyOf($array, ...$elements_to_find);

        $this->assertIsArray($array_filtered);
        $this->assertCount($expected_quantity, $array_filtered);

        $this->assertEquals(array_values(array_filter($array, fn ($key) => in_array($key, $keys_expected), ARRAY_FILTER_USE_KEY)), $array_filtered);
    }

    /**
     * @dataProvider finderElementProvider
     */
    public function test_find_elements_recursive($to_find, $expected_quantity): void
    {
        $array = [
            0 => CustomActionFactory::link('Test', 'https://test.com'),
            1 => FilterFactory::period('Created at', 'created_at'),
            2 => LabelFactory::text('Title', 'title'),
            3 => LabelFactory::text('Title', 'title'),
            4 => new Card('', [
                InputFactory::textarea('Title', 'title'),
                LabelFactory::text('Title', 'title'),
            ])
        ];

        $array_filtered = Finder::findElementsRecursive($array, $to_find);

        $this->assertIsArray($array_filtered);
        $this->assertCount($expected_quantity, $array_filtered);
    }

    public function test_fill_in_card()
    {
        $test = Finder::fillInCard([
            InputFactory::textarea('Title', 'title'),
            InputFactory::text('Title', 'title'),
            new Card('', [
                InputFactory::textarea('Title', 'title'),
                LabelFactory::text('Title', 'title'),
            ])
        ]);

        $this->assertContainsOnly(Card::class, $test);
        $this->assertCount(2, $test);
    }

    
}
