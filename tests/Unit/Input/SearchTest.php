<?php

namespace S4mpp\AdminPanel\Tests\Unit\Input;

use Workbench\App\Models\User;
use S4mpp\AdminPanel\Input\Text;
use S4mpp\AdminPanel\Input\Search;
use S4mpp\AdminPanel\Tests\TestCase;

final class SearchTest extends TestCase
{
    public function test_create_instance(): void
	{
		$search = new Search('Title', 'field', User::class, 'name');

		$this->assertSame(User::class, $search->getModelName());
		$this->assertSame('name', $search->getModelField());
	}    
}
