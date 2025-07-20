<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Proyecto extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;
    protected $table = 'proyectos';
    protected $primaryKey = 'idProyecto';
    public $incrementing = true;
    protected $keyType = 'int';

    /** Asignación masiva */
    protected $fillable = [
        'idPlan',
        'idPrograma',
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

    //El proyecto pertenece a un Plan
    public function plan()
    {
        return $this->belongsTo(
            Plan::class,
            'idPlan',          // FK en esta tabla
            'idPlan'           // PK en planes
        );
    }

    public function programa()
    {
        return $this->belongsTo(
            ProgramaInstitucional::class,
            'idPrograma',
            'idPrograma'
        );
    }

    //Acceso al Programa vía Plan
    public function getprograma()
    {
        //$proyecto->programa
        return $this->plan ? $this->plan->programa() : null;
    }

    //Acceso al Objetivo Estratégico vía Programa y Plan
    public function objetivo()
    {
        return $this->plan?->programa()?->objetivo();
    }

    public function getRutaAttribute(): string
    {
        $obj  = $this->programa?->objetivo?->codigo ?? 'OBJ';
        $prog = $this->programa?->codigo ?? 'PRG';
        $plan = $this->plan?->codigo ?? 'PLN';
        $proj = $this->codigo ?? 'PRY';

        return "{$obj} › {$prog} › {$plan} › {$proj}";
    }
}