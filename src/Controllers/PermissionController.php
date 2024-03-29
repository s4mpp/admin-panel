<?php

namespace S4mpp\AdminPanel\Controllers;

use ReflectionClass;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use S4mpp\Laraguard\Laraguard;
use Illuminate\Validation\Rule;
use S4mpp\AdminPanel\AdminPanel;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Contracts\View\Factory as ViewFactory;

/**
 * @codeCoverageIgnore
 */
final class PermissionController extends Controller
{
    public function __invoke(): ViewFactory|ViewContract|null
    {
        $roles = Role::get();

        $permissions = Permission::get();

        $permissions_admin = new Collection();

        /**
         * @duplicated_code 5
         */
        $permissions_admin = $permissions->filter(fn ($permission) => Str::contains($permission->name, 'Admin'));

        $resources_with_permissions = [
            [
                /**
                 * @duplicated_code 4
                 */
                'name' => 'Admin',
                'permissions' => $permissions_admin->map(function ($permission) {
                    /**
                     * @duplicated_code 1
                     */
                    $trait = HasRoles::class;

                    $reflection = new ReflectionClass(Auth::guard($permission->guard)->getProvider()->getModel());

                    if (isset($reflection->getTraits()[$trait])) {
                        $total_permission_via_roles = Auth::guard($permission->guard)->getProvider()->getModel()::whereHas('roles.permissions', function ($query) use ($permission): void {
                            $query->where('permissions.id', $permission->id);
                        })->count();
                    }

                    $total_direct_permissions = $permission->users()->count();

                    $permission->total_users = ($total_direct_permissions + ($total_permission_via_roles ?? 0));

                    return $permission;
                }),
            ],
        ];

        foreach (AdminPanel::getResources() as $key => $resource) {
            /**
             * @duplicated_code 5
             */
            $permissions_resource = $permissions->filter(fn ($permission) => Str::contains($permission->name, $resource->getName()));

            if ($permissions_resource->isEmpty()) {
                continue;
            }

            $resources_with_permissions[] = [
                /**
                 * @duplicated_code 4
                 */
                'name' => $resource->getTitle(),
                'permissions' => $permissions_resource->map(function ($permission) {
                    /**
                     * @duplicated_code 1
                     */
                    $trait = HasRoles::class;

                    $reflection = new ReflectionClass(Auth::guard($permission->guard)->getProvider()->getModel());

                    if (isset($reflection->getTraits()[$trait])) {
                        $total_permission_via_roles = Auth::guard($permission->guard)->getProvider()->getModel()::whereHas('roles.permissions', function ($query) use ($permission): void {
                            $query->where('permissions.id', $permission->id);
                        })->count();
                    }

                    $total_direct_permissions = $permission->users()->count();

                    $permission->total_users = ($total_direct_permissions + ($total_permission_via_roles ?? 0));

                    return $permission;
                }),
            ];

            $permissions_admin = $permissions_admin->concat($permissions_resource);
        }

        $other_permissions = Permission::whereNotIn('name', $permissions_admin->pluck('name'))->get();

        /**
         * @duplicated_code 1
         */
        $other_permissions = $other_permissions->map(function ($permission) {
            $total_permission_via_roles = Auth::guard($permission->guard)->getProvider()->getModel()::whereHas('roles.permissions', function ($query) use ($permission): void {
                $query->where('permissions.id', $permission->id);
            })->count();

            $total_direct_permissions = $permission->users()->count();

            $permission->total_users = ($total_direct_permissions + $total_permission_via_roles);

            return $permission;
        });

        return Laraguard::layout('admin::roles-and-permissions.index', compact('resources_with_permissions', 'other_permissions', 'roles'));
    }

    public function generatePermissionsAdmin(): RedirectResponse
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions_to_create = $this->getPermissionsToCreate();

        $created = $this->createPermissions($permissions_to_create);

        $removed = $this->removePermissionsNotUsed($permissions_to_create);

        return back()->withMessage('Permissões atualizadas com sucesso!');
    }

    public function createPermission(Request $request): RedirectResponse
    {
        /**
         * @duplicated_code 2
         */
        $request->validate([
            'permission_name' => ['required', 'string', 'max:255', Rule::unique('permissions', 'name')],
        ]);

        $permission = Permission::make(['name' => $request->get('permission_name'), 'guard' => AdminPanel::getGuardName()]);

        $permission->name = $request->get('permission_name');

        $permission->saveOrFail();

        return back()->withMessage('Permissão criada com sucesso!');
    }

    public function updatePermission(int $id, Request $request): RedirectResponse
    {
        /**
         * @duplicated_code 2
         */
        $request->validate([
            'permission_name' => ['required', 'string', 'max:255', Rule::unique('permissions', 'name')->ignore($id)],
        ]);

        $permission = Permission::findById($id, AdminPanel::getGuardName());

        $permission->name = $request->get('permission_name');

        $permission->saveOrFail();

        return back()->withMessage('Permissão atualizada com sucesso!');
    }

    public function deletePermission(int $id): RedirectResponse
    {
        $permission = Permission::findById($id, AdminPanel::getGuardName());

        $permission->delete();

        return back()->withMessage('Permissão removida com sucesso!');
    }

    public function createRole(Request $request): RedirectResponse
    {
        /**
         * @duplicated_code 3
         */
        $request->validate([
            'role_name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'permissions' => ['required', 'array', 'min:1'],
        ]);

        $role = Role::make(['name' => $request->get('role_name'), 'guard_name' => AdminPanel::getGuardName()]);

        $role->saveOrFail();

        /** @var array<string> $permissions */
        $permissions = $request->get('permissions');

        foreach ($permissions as $permission_name) {
            $permission = Permission::findByName($permission_name, AdminPanel::getGuardName());

            $permission->assignRole($role);
        }

        return back()->withMessage('Grupo criado com sucesso!');
    }

    public function updateRole(int $id, Request $request): RedirectResponse
    {
        /**
         * @duplicated_code 3
         */
        $request->validate([
            'role_name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($id)],
            'permissions' => ['required', 'array', 'min:1'],
        ]);

        $role = Role::findById($id, AdminPanel::getGuardName());

        $role->name = $request->get('role_name');

        $role->saveOrFail();

        $permissions_to_sync = [];

        /** @var array<string> $permissions */
        $permissions = $request->get('permissions');

        foreach ($permissions as $permission_name) {
            $permission = Permission::findByName($permission_name, AdminPanel::getGuardName());

            $permissions_to_sync[] = $permission;
        }

        $role->syncPermissions(array_filter($permissions_to_sync));

        return back()->withMessage('Grupo atualizado com sucesso!');
    }

    public function deleteRole(int $id): RedirectResponse
    {
        $role = Role::findById($id, AdminPanel::getGuardName());

        $role->delete();

        return back()->withMessage('Grupo removido com sucesso!');
    }

    /**
     * @return array<string>
     */
    private function getPermissionsToCreate(): array
    {
        $resources = AdminPanel::getResources();

        $permissions_to_create = [];

        foreach ($resources as $resource) {

            $permissions_to_create[] = $resource->getName();

            foreach ($resource->getActions() as $action) {
                $permissions_to_create[] = $resource->getName().'.action.'.$action;
            }

            foreach ($resource->getCustomActions() as $custom_action) {
                $permissions_to_create[] = $resource->getName().'.custom-action.'.$custom_action->getSlug();
            }
            foreach ($resource->getReports() as $report) {
                $permissions_to_create[] = $resource->getName().'.report.'.$report->getSlug();
            }
        }

        return array_merge($permissions_to_create, [
            'Admin.settings', 'Admin.permissions',
        ]);
    }

    /**
     * @param  array<string>  $permissions_to_create
     * @return array<string>
     */
    private function createPermissions(array $permissions_to_create): array
    {
        foreach ($permissions_to_create as $name_permission) {
            $permission = Permission::findOrCreate($name_permission, AdminPanel::getGuardName());

            if (! $permission->exists) {
                $permissions_created[] = $name_permission;
            }
        }

        return $permissions_created ?? [];
    }

    /**
     * @param  array<string>  $permissions_to_create
     * @return array<string>
     */
    private function removePermissionsNotUsed(array $permissions_to_create): array
    {
        $all_permissions = Permission::where('guard_name', AdminPanel::getGuardName())->get();

        foreach ($all_permissions as $permission) {
            if (! in_array($permission->name, $permissions_to_create)) {
                $name = $permission->name;

                $permission->delete();

                $permissions_removed[] = $name;
            }
        }

        return $permissions_removed ?? [];
    }
}
