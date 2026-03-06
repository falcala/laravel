<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\Models\Role;

class PermissionSeeder extends Seeder
{
    // Modules with standard view/create/edit/delete grid
    public static array $modules = [
        'roles',
        'users',
        'pages',
        // 'products',
        // 'orders',
    ];

    public static array $actions = ['view', 'create', 'edit', 'delete'];

    // Custom permissions outside the standard grid: 'permission.name' => 'Label description'
    public static array $extra = [
        'frontpages.edit'   => 'Front Page — Editar propia',
        'frontpages.manage' => 'Front Page — Gestionar todas (admin)',
    ];

    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (self::$modules as $module) {
            foreach (self::$actions as $action) {
                Permission::firstOrCreate([
                    'name'       => "{$module}.{$action}",
                    'guard_name' => 'web',
                ]);
            }
        }

        // Extra custom permissions
        foreach (array_keys(self::$extra) as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // Admin always gets everything
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions(Permission::where('guard_name', 'web')->get());
    }
}