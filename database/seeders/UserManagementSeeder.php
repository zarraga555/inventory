<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class UserManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Estructura: [module => [submodule => [acciones]]]
        $structure = [
            'UserManagement' => [
                'users' => ['view', 'create', 'update', 'delete'],
                'roles' => ['view', 'create', 'update', 'delete'],
                'logs'  => ['view'],
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

        // Crear roles
        $superAdmin = Role::updateOrCreate(['name' => 'super-admin']);
        // Asignar permisos a cada rol
        $superAdmin->givePermissionTo(Permission::all());

        // Crear usuario
        $user = User::create([
            'name' => 'Juan Alberto Zarraga Torrico',
            'email' => 'zarraga555@hotmail.es',
            'password' => Hash::make('password'),
        ]);

        // Asignar rol admin
        $user->assignRole('super-admin');
    }
}
