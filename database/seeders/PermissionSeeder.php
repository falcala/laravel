<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\Models\Role;

class PermissionSeeder extends Seeder
{
    // Add your modules here — extend this list as your app grows
    public static array $modules = [
        'roles',
        'users',
        'pages',
        // 'products',
        // 'orders',
    ];

    public static array $actions = ['view', 'create', 'edit', 'delete'];

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

        // Admin always gets everything
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions(Permission::where('guard_name', 'web')->get());
    }
}