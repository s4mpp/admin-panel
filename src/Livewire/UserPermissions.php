<?php

namespace S4mpp\AdminPanel\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use S4mpp\AdminPanel\AdminPanel;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Contracts\View\Factory as ViewFactory;

/**
 * @codeCoverageIgnore
 */
final class UserPermissions extends Component
{
    /**
     * @var Collection<int,Role>
     */
    public Collection $roles;

    /**
     * @var array<string|mixed>
     */
    public array $resources_with_permissions;

    /**
     * @var array<int>
     */
    public array $roles_selected = [];

    /**
     * @var array<int>
     */
    public array $permissions_selected = [];

    public User $user;

    public int $total_permissions_selected = 0;

    public function mount(User $user): void
    {
        $this->user = $user;

        $this->roles = Role::where('guard_name', config('admin.guard', 'web'))->get();

        $this->roles->map(function ($role) {
            $role->total_permissions = $role->permissions()->count();

            return $role;
        });

        $permissions = Permission::where('guard_name', config('admin.guard', 'web'))->get();

        $permissions_admin = $permissions->filter(fn ($permission) => Str::contains($permission->name, 'Admin'));

        $resources_with_permissions = [
            [
                'name' => 'Admin',
                'permissions' => $permissions_admin->toArray(),
            ],
        ];

        foreach (AdminPanel::getResources() as $key => $resource) {
            $permissions_resource = $permissions->filter(fn ($permission) => Str::contains($permission->name, $resource->getName()));

            if ($permissions_resource->isEmpty()) {
                continue;
            }

            $resources_with_permissions[] = [
                'name' => $resource->getTitle(),
                'permissions' => $permissions_resource->toArray(),
            ];
        }

        $this->resources_with_permissions = $resources_with_permissions;

        $this->setRolesAndPermissionsSelected();
    }

    public function render(): View|ViewFactory
    {
        return view('admin::livewire.user-permissions');
    }

    public function save(): void
    {
        $this->validate([
            'roles_selected' => ['array'],
        ]);

        $roles = $permissions = [];

        foreach ($this->roles_selected as $role_id) {
            $role = Role::findById($role_id, config('admin.guard', 'web'));

            if (! $role->exists) {
                continue;
            }

            $roles[] = $role;
        }

        $this->user->syncRoles($roles);

        foreach ($this->permissions_selected as $permission_id) {
            $permission = Permission::findById($permission_id, config('admin.guard', 'web'));

            if (! $permission->exists) {
                continue;
            }

            $permissions[] = $permission;
        }

        $this->user->syncPermissions($permissions);

        $this->user->refresh();

        $this->setRolesAndPermissionsSelected();

        $this->dispatchBrowserEvent('close-slide');
    }

    private function setRolesAndPermissionsSelected(): void
    {
        $this->roles_selected = $this->user->roles?->pluck('id')->toArray() ?? [];
        $this->permissions_selected = $this->user->permissions?->pluck('id')->toArray() ?? [];

        $this->total_permissions_selected = count($this->permissions_selected);
    }
}
