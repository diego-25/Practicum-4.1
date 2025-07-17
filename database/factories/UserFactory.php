<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Institucion;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $institucion = Institucion::inRandomOrder()->first()?? Institucion::factory()->create();
        return [
            'name'=>$this->faker->name(),
            'email'=>$this->faker->unique()->safeEmail(),
            'email_verified_at'=>now(),
            'password'=>'password',
            'telefono'=>$this->faker->regexify('09[0-9]{8}'),
            'cargo'=>$this->faker->randomElement(['Analista', 'Inspector', 'Técnico', 'Coordinador']),
            'estado'=>true,
            'actor'=>$this->faker->randomElement(array_keys(User::ACTOR_ROLE_MAP)),
            'remember_token'=>Str::random(10),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
            $institucion = Institucion::inRandomOrder()->first()?? Institucion::factory()->create();

            // tabla pivote institucion_user
            $user->instituciones()->attach($institucion->idInstitucion);
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
