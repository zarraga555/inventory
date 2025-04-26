<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            'user' => ['create', 'update', 'delete', 'view'],
            'role' => ['create', 'update', 'delete', 'view'],
        ];

        foreach ($modules as $module => $permissions) {
            foreach ($permissions as $permission) {
                \Spatie\Permission\Models\Permission::updateOrCreate([
                    'name' => "{$permission}  {$module}",
                ]);
            }
        }
    }
}
