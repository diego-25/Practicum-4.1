<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    use HasFactory;
    protected $primaryKey='idInstitucion';
    public $timestamps=false;
    protected $table='instituciones';
    public $incrementing=true;
    protected $keyType='int';
    protected $fillable = [
        'codigo',
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
    //public function planes()
    //{
    //    return $this->hasMany(Plan::class);
    //}
    public function usuarios()
    {
        return $this->belongsToMany(
            User::class,
            'institucion_user',
            'idInstitucion',
            'idUsuario'
        );
    }
}