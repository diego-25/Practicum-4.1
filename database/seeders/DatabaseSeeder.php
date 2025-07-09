<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /* 1. Roles y permisos */
        $this->call(RolePermissionSeeder::class);

        /* 2. Usuario administrador principal */
        $admin = User::factory()->create([
            'name'              => 'Administrador',
            'email'             => 'administrador@sipeip.test',
            'password'          => 'administrador',
            'telefono'          => '0999999999',
            'cargo'             => 'Gerente TI',
            'actor'             => 'ADMIN_SISTEMA',
            'estado'            => true,
            'email_verified_at' => now(),
        ]);

        // Asigna los roles
        $admin->syncRoles(['Tecnico','Funcional','Control','Reportador']);

        /* 3. Usuarios de demo */
        User::factory(3)->create();
    }
}
