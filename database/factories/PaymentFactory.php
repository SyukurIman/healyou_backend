<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_donasi' => $this->faker->numberBetween(0, 5000),
            'nominal_key' => $this->faker->numberBetween(90000, 10000000),
            'status' => $this->faker->numberBetween(0,1),
        ];
    }
}
