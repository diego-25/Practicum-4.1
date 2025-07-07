<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $primaryKey='idUsuario';
    protected $table='users';
    protected $fillable = [
        'name', 
        'email', 
        'password',
        'telefono', 
        'cargo', 
        'estado', 
        'actor',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'estado'            => 'boolean',
    ];

    /** Guard explícito (útil si agregas más guards) */
    // protected string $guard_name = 'web';

    /** Actor → Roles */
    public const ACTOR_ROLE_MAP = [
        'ADMIN_SISTEMA'         => ['Tecnico','Funcional','Control','Reportador'],
        'TECNICO_PLANIFICACION' => ['Tecnico'],
        'REVISOR_INSTITUCIONAL' => ['Funcional','Control'],
        'AUTORIDAD_VALIDANTE'   => ['Control'],
        'USUARIO_EXTERNO'       => ['Reportador'],
        'AUDITOR'               => ['Control','Reportador'],
    ];

    protected static function booted(): void
    {
        static::created(function (self $user) {
            $roleNames = self::ACTOR_ROLE_MAP[$user->actor] ?? [];

            // si ya los sembraste usa assignRole directamente
            foreach ($roleNames as $name) {
                Role::findOrCreate($name, $user->guard_name); // garantiza existencia
            }

            $user->syncRoles($roleNames); // asigna/sincroniza
        });
    }
}