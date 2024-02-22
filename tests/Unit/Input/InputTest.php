<?php

namespace S4mpp\AdminPanel\Tests\Unit\CustomActions;

use S4mpp\AdminPanel\Input\Text;
use S4mpp\AdminPanel\Tests\TestCase;

final class InputTest extends TestCase
{
    public function test_create_instance(): void
    {
        $text = new Text('Title', 'field');

        $text->prefix('register');
        $text->description('Description of input');
        $text->prepareForForm(function (): void {
        });

        $this->assertSame('Title', $text->getTitle());
        $this->assertSame('register.field', $text->getNameWithPrefix());
        $this->assertSame('Description of input', $text->getDescription());
        $this->assertIsCallable($text->getPrepareForForm());
    }
}
