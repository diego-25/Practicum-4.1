<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    protected $primaryKey='idInstitucion';
    public $timestamps=false;
    protected $table='instituciones';
    public    $incrementing=true;
    protected $keyType='int';
    protected $fillable = [
        'nombre',
        'siglas',
        'ruc',
        'email',
        'telefono',
        'direccion',
        'estado'
    ];
    protected $casts = [
        'estado' => 'boolean',
    ];
    public function getCodigoAttribute(): string
    {
        return str_pad($this->attributes['idInstitucion'], 6, '0', STR_PAD_LEFT);
    }
    //public function usuarios()
    //{
    //    return $this->hasMany(User::class);
    //}
    //public function planes()
    //{
    //    return $this->hasMany(PlanInstitucional::class);
    //}
}