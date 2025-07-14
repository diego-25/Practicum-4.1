<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Objetivo;

class ObjetivoFactory extends Factory
{
    protected $model = Objetivo::class;
    public function definition(): array
    {
        $desde = $this->faker->dateTimeBetween('-4 years', 'now');
        $hasta = (clone $desde)->modify('+'.rand(1,4).' years');
        
        return [
            'codigo'         => 'OE-' . $this->faker->unique()->numerify('######'),
            'nombre'         => Str::headline($this->faker->sentence(4)),
            'descripcion'    => $this->faker->paragraph(),
            'tipo'           => $this->faker->randomElement(['INSTITUCIONAL','ODS','PND']),
            'vigencia_desde' => $desde->format('d-m-Y'),
            'vigencia_hasta' => $hasta->format('d-m-Y'),
            'estado'         => true,
        ];
    }
}
