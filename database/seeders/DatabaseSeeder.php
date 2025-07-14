<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Institucion;
use App\Models\Objetivo;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Roles y permisos
        $this->call(RolePermissionSeeder::class);

        // Usuario administrador principal
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

        // Usuarios de demo
        User::factory(3)->create();
        Institucion::factory(10)->create();
        Objetivo::factory(5)->create();
    }
}
