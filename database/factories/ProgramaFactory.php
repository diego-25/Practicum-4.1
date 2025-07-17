<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Programa;
use App\Models\Objetivo;

class ProgramaFactory extends Factory
{
    protected $model = Programa::class;

    public function definition(): array
    {
        // obtiene o crea un objetivo al azar
        $objetivo = Objetivo::inRandomOrder()->first()?? Objetivo::factory()->create();

        // vigencia lógica
        $desde = $this->faker->dateTimeBetween('-3 years', 'now');
        $hasta = (clone $desde)->modify('+'.rand(1,3).' years');

        return [
            'idObjetivo' => $objetivo->idObjetivo,
            'codigo'=>'PR-'. $this->faker->unique()->numerify('######'),
            'nombre'=>$this->faker->sentence(4),
            'descripcion'=>$this->faker->paragraph(),
            'vigencia_desde'=>$desde->format('d-m-Y'),
            'vigencia_hasta'=>$hasta->format('d-m-Y'),
            'estado'=>$this->faker->boolean(90),
        ];
    }
}