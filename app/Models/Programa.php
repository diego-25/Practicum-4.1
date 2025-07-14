<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Programa extends Model
{
    use HasFactory;
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
            ObjetivoEstrategico::class,
            'idObjetivo',
            'idObjetivoEstrategico'
        );
    }
    
    //Un programa puede tener uno o varios planes
    public function planes()
    {
        return $this->hasMany(
            PlanInstitucional::class,
            'idPrograma',
            'idPrograma'
        );
    }

    //Acceso a proyectos a través de planes (requires hasManyThrough)
    public function proyectos()
    {
        return $this->hasManyThrough(
            ProyectoInstitucional::class,
            PlanInstitucional::class,
            'idPrograma',
            'idPlan',
            'idPrograma',
            'idPlan'
        );
    }
}