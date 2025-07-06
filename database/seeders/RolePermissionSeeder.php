<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Limpia cache de permisos
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        DB::transaction(function () {

            /* -------------------- 1) Crear permisos -------------------- */
            $permissions = [
                // Usuarios
                'usuarios.view',
                'usuarios.create',
                'usuarios.edit',
                'usuarios.delete',
                'usuarios.assign_roles',

                // Instituciones
                'instituciones.view',
                'instituciones.create',
                'instituciones.edit',
                'instituciones.delete',
                'instituciones.export',

                // Objetivos
                'objetivos.view','objetivos.create',
                'objetivos.edit',
                'objetivos.approve',
                'objetivos.delete',
                'objetivos.export',

                // Planes
                'planes.view',
                'planes.create',
                'planes.edit',
                'planes.approve',
                'planes.delete',
                'planes.export',

                // Programas
                'programas.view',
                'programas.create',
                'programas.edit',
                'programas.delete',
                'programas.export',

                // Proyectos
                'proyectos.view',
                'proyectos.create',
                'proyectos.edit',
                'proyectos.send_dictamen',
                'proyectos.approve',
                'proyectos.close',
                'proyectos.export',

                // Reportes
                'reportes.view',
                'reportes.config_templates',
                'reportes.generate',

                // Auditoría
                'auditoria.view',
            ];

            foreach ($permissions as $p) {
                Permission::firstOrCreate(['name' => $p, 'guard_name' => 'web']);
            }

            /* -------------------- 2) Crear roles ----------------------- */
            foreach (['Tecnico','Funcional','Control','Reportador'] as $roleName) {
                Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            }

            /* -------------------- 3) Asignar permisos ------------------ */
            $allView    = Permission::where('name','like','%.view')->pluck('name')->all();
            $allCreate  = Permission::where('name','like','%.create')->pluck('name')->all();
            $allEdit    = Permission::where('name','like','%.edit')->pluck('name')->all();
            $allDelete  = Permission::where('name','like','%.delete')->pluck('name')->all();
            $allApprove = Permission::where('name','like','%.approve')->pluck('name')->all();

            // Técnico
            Role::findByName('Tecnico')->syncPermissions(array_merge(
                $allView, $allCreate, $allEdit, $allDelete,
                ['reportes.generate']
            ));

            // Funcional
            Role::findByName('Funcional')->syncPermissions(array_merge(
                $allView, $allApprove, ['reportes.view']
            ));

            // Control
            Role::findByName('Control')->syncPermissions([
                ...$allView,
                'objetivos.approve','planes.approve',
                'proyectos.send_dictamen',
                'auditoria.view','reportes.view',
            ]);

            // Reportador
            Role::findByName('Reportador')->syncPermissions([
                'objetivos.view',
                'objetivos.create',
                'objetivos.edit',
                'planes.view',
                'planes.create',
                'planes.edit',
                'programas.view',
                'programas.create',
                'programas.edit',
                'proyectos.view',
                'proyectos.create',
                'proyectos.edit',
                'reportes.view',
            ]);
        });
    }
}