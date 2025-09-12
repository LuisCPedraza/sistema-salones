<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role; // <-- Importante importar el modelo

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'coordinador']);
        Role::create(['name' => 'profesor']);
    }
}
