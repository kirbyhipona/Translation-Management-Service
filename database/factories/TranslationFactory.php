<?php

namespace Database\Factories;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Translation>
 */
class TranslationFactory extends Factory
{
    protected $model = Translation::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            't_key' => 'key_' . $this->faker->unique()->numerify('########'),
            'locale' => fake()->randomElement(['en', 'fr', 'es', 'de']),
            'content' => fake()->sentence(),
        ];
    }
}
