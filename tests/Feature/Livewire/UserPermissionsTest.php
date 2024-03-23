<?php

namespace S4mpp\AdminPanel\Tests\Feature\Livewire;

use Livewire\Livewire;
use Workbench\App\Models\User;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\Livewire\FormSettings;
use S4mpp\AdminPanel\Livewire\UserPermissions;
use Workbench\Database\Factories\UserFactory;

final class UserPermissionsTest extends TestCase
{
    public function test_save()
	{
		$user = UserFactory::new()->create();

		$component = Livewire::test(UserPermissions::class, [
			'user' => $user,
		])
		->call('save');

		$component->assertDispatched('close-slide');
	}
}
