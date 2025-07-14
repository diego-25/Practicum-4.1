<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Institucion;

class InstitucionFactory extends Factory
{
    protected $model = Institucion::class;
    public function definition(): array
    {
        return [
            'nombre'    => $this->faker->company(),
            'siglas'    => strtoupper($this->faker->lexify('???')),
            'ruc'       => $this->faker->unique()->numerify('##########'),
            'email'     => $this->faker->unique()->companyEmail(),
            'telefono'  => $this->faker->regexify('09[0-9]{8}'),
            'direccion' => $this->faker->address(),
            'estado'    => true,
        ];
    }
}
