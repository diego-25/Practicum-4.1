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

        //SIPeIP
        $sipeip = Institucion::firstOrCreate([
                'nombre'    => 'Sistema Integrado de Planificación e Inversión Pública',
                'siglas'    => 'SIPeIP',
                'ruc'       => '9999999999',
                'email'     => 'sipeip@ejemplo.com',
                'telefono'  => '0999999999',
                'direccion' => 'Quito, Ecuador',
                'estado'    => true,
            ]
        );

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
        //juntar sipeip con admin
        $admin->instituciones()->syncWithoutDetaching([$sipeip->idInstitucion]);

        // clases de demo
        $instituciones = Institucion::factory(10)->create();
        User::factory(5)->create()->each(function (User $user) use ($instituciones) {
            $id = $instituciones->random()->idInstitucion;
            $user->instituciones()->attach($id);
        });
        Objetivo::factory(5)->create();
    }
}
