<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $body_core = join('</p><p>', $this->faker->paragraphs(random_int(3, 6)));
        return [
            'title' => $this->faker->sentence,
            'body' => "<p>{$body_core}</p>",
        ];
    }
}
