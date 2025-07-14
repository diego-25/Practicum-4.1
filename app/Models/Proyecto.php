<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $table = 'proyectos';
    protected $primaryKey  = 'idProyecto';
    public    $incrementing = true;
    protected $keyType      = 'int';

    /** Asignación masiva */
    protected $fillable = [
        'idPlan',
        'codigo',
        'nombre',
        'descripcion',
        'monto_presupuesto',
        'fecha_inicio',
        'fecha_fin',
        'estado',
    ];

    protected $casts = [
        'fecha_inicio'      => 'date',
        'fecha_fin'         => 'date',
        'monto_presupuesto' => 'decimal:2',
        'estado'            => 'boolean',
    ];

    //El proyecto pertenece a un Plan Institucional
    public function plan()
    {
        return $this->belongsTo(
            PlanInstitucional::class,
            'idPlan',          // FK en esta tabla
            'idPlan'           // PK en planes
        );
    }

    //Acceso al Programa vía Plan
    public function programa()
    {
        //$proyecto->programa
        return $this->plan ? $this->plan->programa() : null;
    }

    //Acceso al Objetivo Estratégico vía Programa y Plan
    public function objetivo()
    {
        return $this->plan?->programa()?->objetivo();
    }
}