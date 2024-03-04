<?php

namespace S4mpp\AdminPanel\Tests\Unit\Input;

use S4mpp\AdminPanel\Input\Text;
use S4mpp\AdminPanel\Input\Textarea;
use S4mpp\AdminPanel\Tests\TestCase;

final class TextareaTest extends TestCase
{
    public function test_create_instance(): void
    {
        $textarea = new Textarea('Title', 'field');

		
        $textarea->description('Description of input');
		
        $this->assertSame('Title', $textarea->getTitle());
        $this->assertSame('data.field', $textarea->getNameWithPrefix());
        $this->assertSame('Description of input', $textarea->getDescription());
		$this->assertSame(4, $textarea->getRows());
    }

	public function test_rows(): void
	{
		$textarea = new Textarea('Title', 'field', 5);

		$this->assertIsInt($textarea->getRows());
		$this->assertSame(5, $textarea->getRows());
	}

	public function test_attributes(): void
    {
		$textarea = new Textarea('Title', 'field');

		$attributes = $textarea->getAttributes();

		$this->assertIsArray($attributes);
		$this->assertSame(['rows' => 4], $attributes);
	}
}
