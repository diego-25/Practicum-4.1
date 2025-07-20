<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Proyecto;
use App\Models\Plan;

class ProyectoFactory extends Factory
{
    protected $model = Proyecto::class;

    public function definition(): array
    {

        $inicio=$this->faker->dateTimeBetween('-1 year', 'now');
        $fin=(clone $inicio)->modify('+'.rand(3,18).' months');

        $plan = Plan::inRandomOrder()->first() ?? Plan::factory()->create();

        return [
            'idPlan'     => $plan->idPlan,
            'idPrograma' => $plan->idPrograma,
            'codigo'=>'PRY-'. $this->faker->unique()->numerify('######'),
            'nombre'=>$this->faker->sentence(4),
            'descripcion'=>$this->faker->paragraph(2),
            'monto_presupuesto'=>$this->faker->randomFloat(2, 10000, 5000000),
            'fecha_inicio'=>$inicio->format('d-m-Y'),
            'fecha_fin'=>$fin->format('d-m-Y'),
            'estado'=>$this->faker->boolean(90),
        ];
    }
}