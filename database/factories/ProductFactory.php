<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'name' => $this->faker->name,
            'category' => $this->faker->name,
            'band' => $this->faker->word,
            'description' => $this->faker->realText($maxNbChars = 200, $indexSize = 2),
            'image' => $this->faker->imageUrl($width = 640, $height = 480),
            'quantity' => $this->faker->biasedNumberBetween($min = 5, $max = 20, $function = 'sqrt'),
            'price' => $this->faker->randomNumber(3),

        ];
    }
}
