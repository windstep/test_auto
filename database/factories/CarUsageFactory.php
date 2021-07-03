<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\CarUsage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarUsageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CarUsage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'car_id' => Car::first()->id,
            'user_id' => User::first()->id,
            'time_from' => '2020-01-01 12:30',
            'time_to' => '2020-01-01 13:00'
        ];
    }
}
