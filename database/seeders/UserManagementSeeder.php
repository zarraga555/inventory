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
        $modules = [
            'users' => ['view', 'create', 'update', 'delete', 'logs.view'],
            'roles' => ['view', 'create', 'update', 'delete'],
        ];

        foreach ($modules as $module => $actions) {
            foreach ($actions as $action) {
                // Si el permiso tiene punto (ej: logs.view), extrae solo la acción
                $name = "{$module}.{$action}";
                $mainModule = explode('.', $name)[0]; // para la columna module

                Permission::updateOrCreate(
                    ['name' => $name],
                    ['module' => $mainModule]
                );
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
