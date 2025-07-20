<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Plan extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;
    protected $table = 'planes';
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


    //Un plan posee uno o varios proyectos
    public function proyectos()
    {
        return $this->hasMany(
            Proyecto::class,
            'idPlan',      // FK en proyectos
            'idPlan'       // PK local
        );
    }
}
