<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objetivo extends Model
{
    use HasFactory;

    protected $table = 'objetivos';
    protected $primaryKey = 'idObjetivo';

    /** Auto-incremental y tipo int (MEDIUMINT) */
    public $incrementing = true;
    protected $keyType   = 'int';

    /** Campos que pueden asignarse de forma masiva */
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'tipo',
        'vigencia_desde',
        'vigencia_hasta',
        'estado',
    ];

    protected $casts = [
        'vigencia_desde' => 'date',
        'vigencia_hasta' => 'date',
        'estado'         => 'boolean',
    ];

    // Relaciones
    // Un objetivo estratégico puede tener uno o varios programas
    public function programas()
    {
        return $this->hasMany(
            Programa::class,
            'idObjetivo',
            'idObjetivo'
        );
    }

    public function planes()
    {
        return $this->hasManyThrough(
            PlanInstitucional::class,
            Programa::class,
            'idObjetivo',
            'idPrograma',
            'idObjetivo',
            'idPrograma'
        );
    }
}