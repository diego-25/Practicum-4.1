<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Institucion;

class InstitucionFactory extends Factory
{
    protected $model = Institucion::class;
    public function definition(): array
    {
        return [
            'codigo'=>null,
            'nombre'=>$this->faker->company(),
            'siglas'=>strtoupper($this->faker->lexify('???')),
            'ruc'=>$this->faker->unique()->numerify('##########'),
            'email'=>$this->faker->unique()->companyEmail(),
            'telefono'=>$this->faker->regexify('09[0-9]{8}'),
            'direccion'=>$this->faker->address(),
            'estado'=>true,
        ];
    }
    public function configure(): static
    {
        return $this->afterCreating(function (Institucion $inst) {
            $inst->codigo = 'INS-' . str_pad($inst->idInstitucion, 6, '0', STR_PAD_LEFT);
            $inst->save();
        });
    }
}
