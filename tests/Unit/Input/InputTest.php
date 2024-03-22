<?php

namespace S4mpp\AdminPanel\Tests\Unit\Input;

use Closure;
use Illuminate\Validation\Rules\Unique;
use S4mpp\AdminPanel\Input\Text;
use S4mpp\AdminPanel\Tests\TestCase;

final class InputTest extends TestCase
{
    public function test_create_instance(): void
    {
        $text = new Text('Title', 'field');

        $text->description('Description of input');

        $this->assertSame('Title', $text->getTitle());
        $this->assertSame('data.field', $text->getNameWithPrefix());
        $this->assertSame('Description of input', $text->getDescription());
        $this->assertTrue($text->isRequired());
        $this->assertIsArray($text->getRules());
        $this->assertContains('required', $text->getRules());
    }

    public function test_prepare_for_form(): void
    {
        $text = new Text('Title', 'field');

        $text->prepareForForm(fn() => null);

        $this->assertIsCallable($text->getPrepareForForm());
    }

    public function test_add_rule(): void
    {
        $text = new Text('Title', 'field');

        $text->addRule('size:1');

        $this->assertContains('size:1', $text->getRules());
    }

    public function test_remove_rule(): void
    {
        $text = new Text('Title', 'field');

        $text->addRule('size:2');
        $this->assertContains('size:2', $text->getRules());
        
        $text->removeRule('size:2');
        $this->assertNotContains('size:2', $text->getRules());
    }

    public function test_not_required(): void
    {
        $text = (new Text('Title', 'field'))->notRequired();

        $this->assertFalse($text->isRequired());
        $this->assertNotContains('required', $text->getRules());
    }

    public function test_unique(): void
    {
        $text = (new Text('Title', 'field'))->unique();

        $rules = $text->getRules(); dump($rules);

        $this->assertCount(2, $rules);
        $this->assertInstanceOf(Unique::class, $rules[1]);
    }
}
