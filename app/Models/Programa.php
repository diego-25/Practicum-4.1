<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Programa extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;
    protected $table = 'programas';
    protected $primaryKey = 'idPrograma';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'idObjetivo',
        'codigo',
        'nombre',
        'descripcion',
        'vigencia_desde',
        'vigencia_hasta',
        'estado',
    ];

    protected $casts = [
        'vigencia_desde' => 'date',
        'vigencia_hasta' => 'date',
        'estado'         => 'boolean',
    ];

    //El programa pertenece a un Objetivo Estratégico
    public function objetivo()
    {
        return $this->belongsTo(
            Objetivo::class,
            'idObjetivo',
            'idObjetivo'
        );
    }
    
    //Un programa puede tener uno o varios planes
    public function planes()
    {
        return $this->hasMany(
            Plan::class,
            'idPrograma',
            'idPrograma'
        );
    }

    //Acceso a proyectos a través de planes (requires hasManyThrough)
    public function proyectos()
    {
        return $this->hasManyThrough(
            Proyecto::class,
            Plan::class,
            'idPrograma',
            'idPlan',
            'idPrograma',
            'idPlan'
        );
    }
}