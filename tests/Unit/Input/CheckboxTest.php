<?php

namespace S4mpp\AdminPanel\Tests\Unit\Input;

use S4mpp\AdminPanel\Input\Checkbox;
use S4mpp\AdminPanel\Tests\TestCase;

final class CheckboxTest extends TestCase
{
    public function test_process_input_data(): void
    {
		$date = new Checkbox('Title', 'field');

		$input_data = $date->processInputData(['a' => 'b']);

		$this->assertJson($input_data);
		$this->assertJsonStringEqualsJsonString('{"a":"b"}', $input_data);
	}
}
