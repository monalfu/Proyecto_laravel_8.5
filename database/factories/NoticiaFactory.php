<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Noticia;

class NoticiaFactory extends Factory
{
    protected $model = Noticia::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'titulo' => $this->faker->unique->realTextBetween(5, 15, 4),
            'tema' => $this->faker->randomElement([
                'Política', 'Deporte', 'Economía', 'Cultural', 'Social', 'Entretenimiento', 'Cinetífica', 'Sucesos', 'Corazón'
            ]),
            'texto' => $this->faker->realTextBetween(30, 255, 4),
            'user_id' => $this->faker->numberBetween(4, 10)
        ];
    }
}
