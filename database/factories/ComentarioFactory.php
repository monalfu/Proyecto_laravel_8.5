<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comentario;

class ComentarioFactory extends Factory
{
    protected $model = Comentario::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'texto' => $this->faker->realTextBetween(30, 255, 4),
            'user_id' => $this->faker->numberBetween(11, 30),
            'noticia_id' => $this->faker->numberBetween(1, 10)
        ];
    }
}
