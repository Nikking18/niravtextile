<?php

namespace Database\Factories;

use App\Models\Inword;
use App\Models\InwordReport;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InwordReportFactory extends Factory
{
    protected $model = InwordReport::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'inword_id' => Inword::all()->random()->id,
            'product_name' => $this->faker->unique()->name(),
            'quantity' => $this->faker->randomDigit(),
            'amount' => $this->faker->numberBetween(2500, 5000),
            'created_at' => $this->faker->dateTimeBetween('2021-01-01','2021-12-02'),
        ];
    }
}
