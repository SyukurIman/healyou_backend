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
            // 'id_donasi' => $this->faker->numberBetween(0, 5000),
            // 'price' => $this->faker->numberBetween(90000, 10000000),
            // 'payment_status' => $this->faker->numberBetween(1,1),
        ];
    }
}
