<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    protected $primaryKey='idEntidad';
    public $timestamps = false;
    protected $table = 'entidades';
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
    //public function usuarios()
    //{
    //    return $this->hasMany(User::class);
    //}
    //public function planes()
    //{
    //    return $this->hasMany(PlanInstitucional::class);
    //}
}