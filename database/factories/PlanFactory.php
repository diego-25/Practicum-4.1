<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Plan;
use App\Models\Programa;

class PlanFactory extends Factory
{
    protected $model = Plan::class;

    public function definition(): array
    {
        // obtiene o crea un objetivo al azar
        $programa = Programa::inRandomOrder()->first()?? Programa::factory()->create();

        // vigencia lógica
        $desde = $this->faker->dateTimeBetween('-3 years', 'now');
        $hasta = (clone $desde)->modify('+'.rand(1,3).' years');

        return [
            'idPrograma' => Programa::inRandomOrder()->value('idPrograma')?? Programa::factory(),
            'codigo'=>'PL-'. $this->faker->unique()->numerify('######'),
            'nombre'=>$this->faker->sentence(4),
            'descripcion'=>$this->faker->paragraph(),
            'vigencia_desde'=>$desde->format('d-m-Y'),
            'vigencia_hasta'=>$hasta->format('d-m-Y'),
            'estado'=>true,
        ];
    }
}