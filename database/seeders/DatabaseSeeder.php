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
            'email'             => 'admin@sipeip.test',
            'password'          => 'admin123',       // se hashea por el cast 'hashed'
            'actor'             => 'ADMIN_SISTEMA',
            'email_verified_at' => now(),
        ]);

        // Asigna todos los roles base del actor + alguno extra si quieres
        $admin->syncRoles(['Tecnico','Funcional','Control','Reportador']);

        /* 3. Usuarios de demo */
        User::factory(20)->create();   // generará distintos actores y roles (hook booted)
    }
}
