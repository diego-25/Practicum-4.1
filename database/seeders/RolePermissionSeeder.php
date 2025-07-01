<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Ejecuta el seeder.
     */
    public function run(): void
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        /**
         * {{-- Definir permisos --}}
         */
        $permissions = [

            // --- Módulo Autenticación / Usuarios ---
            'usuarios.view',
            'usuarios.create',
            'usuarios.edit',
            'usuarios.delete',
            'usuarios.assign_roles',

            // --- Instituciones ---
            'instituciones.view',
            'instituciones.create',
            'instituciones.edit',
            'instituciones.delete',
            'instituciones.export',

            // --- Objetivos Estratégicos ---
            'objetivos.view',
            'objetivos.create',
            'objetivos.edit',
            'objetivos.approve',
            'objetivos.delete',
            'objetivos.export',

            // --- Planes Estratégicos ---
            'planes.view',
            'planes.create',
            'planes.edit',
            'planes.approve',
            'planes.delete',
            'planes.export',

            // --- Programas ---
            'programas.view',
            'programas.create',
            'programas.edit',
            'programas.delete',
            'programas.export',

            // --- Proyectos de Inversión ---
            'proyectos.view',
            'proyectos.create',
            'proyectos.edit',
            'proyectos.send_dictamen',
            'proyectos.approve',
            'proyectos.close',
            'proyectos.export',

            // --- Reportes / Dashboards ---
            'reportes.view',
            'reportes.config_templates',
            'reportes.generate',

            // --- Auditoría ---
            'auditoria.view',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }
        /**
         * {{-- Crear roles --}}
         */
        $roles = [
            'Técnico', 
            'Funcional', 
            'Control', 
            'Reportador'
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // {{-- Asignar permisos a roles --}}
        $give = fn(string $role, array $perms) =>
            Role::findByName($role)->givePermissionTo($perms);

        // {{-- Tecnico --}}
        Role::findByName('Técnico')->syncPermissions([
            // acceso CRUD total sobre la información “interna”
            // (excepto operaciones de aprobación / firma)
            ...Permission::where('name', 'like', '%.view')->pluck('name'),
            ...Permission::where('name', 'like', '%.create')->pluck('name'),
            ...Permission::where('name', 'like', '%.edit')->pluck('name'),
            ...Permission::where('name', 'like', '%.delete')->pluck('name'),
            'reportes.generate',
        ]);

        // {{-- Funcional --}}
        Role::findByName('Funcional')->syncPermissions([
            // decisiones finales (approve) + ver
            ...Permission::where('name', 'like', '%.view')->pluck('name'),
            ...Permission::where('name', 'like', '%.approve')->pluck('name'),
            'reportes.view',
        ]);

        // {{-- Control --}}
        Role::findByName('Control')->syncPermissions([
            // tareas de revisión / control de calidad
            ...Permission::where('name', 'like', '%.view')->pluck('name'),
            'objetivos.approve',
            'planes.approve',
            'proyectos.send_dictamen',
            'auditoria.view',
            'reportes.view',
        ]);

        // {{-- Reportador --}}
        Role::findByName('Reportador')->syncPermissions([
            // registrar y exportar su propia data
            'objetivos.view', 'objetivos.create', 'objetivos.edit',
            'planes.view', 'planes.create', 'planes.edit',
            'programas.view', 'programas.create', 'programas.edit',
            'proyectos.view', 'proyectos.create', 'proyectos.edit',
            'reportes.view',
        ]);
    }
}