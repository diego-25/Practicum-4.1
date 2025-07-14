<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;
    protected $table = 'plan';
    protected $primaryKey  = 'idPlan';
    public    $incrementing = true;
    protected $keyType      = 'int';

    protected $fillable = [
        'idPrograma',
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

    //El plan pertenece a un Programa Institucional
    public function programa()
    {
        return $this->belongsTo(
            Programa::class,
            'idPrograma',
            'idPrograma'
        );
    }

    public function objetivo()
    {
        return $this->programa ? $this->programa->objetivo() : null;
    }


    //Un plan posee uno o varios proyectos institucionales
    public function proyectos()
    {
        return $this->hasMany(
            ProyectoInstitucional::class,
            'idPlan',      // FK en proyectos
            'idPlan'       // PK local
        );
    }
}
