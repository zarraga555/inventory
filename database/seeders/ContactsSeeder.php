<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class ContactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Estructura: [module => [submodule => [acciones]]]
        $structure = [
            'Contacts' => [
                'customer' => ['view', 'create', 'update', 'delete'],
                'supplier' => ['view', 'create', 'update', 'delete'],
                'customer-group' => ['view', 'create', 'update', 'delete'],
                'import-contact' => ['view'],
            ],
        ];

        foreach ($structure as $module => $submodules) {
            foreach ($submodules as $submodule => $actions) {
                foreach ($actions as $action) {
                    $permissionName = "{$submodule}.{$action}";

                    Permission::updateOrCreate(
                        ['name' => $permissionName],
                        [
                            'module' => $module,
                            'submodule' => $submodule,
                            'guard_name' => 'web',
                        ]
                    );
                }
            }
        }
        // buscar rol
        $superAdmin = Role::where('name', 'super-admin')->first();
        $superAdmin->syncPermissions(Permission::all());
    }
}
