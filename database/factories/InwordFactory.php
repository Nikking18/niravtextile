<?php

namespace Database\Factories;

use App\Models\Inword;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\In;

class InwordFactory extends Factory
{

    protected $model = Inword::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'party_name' => $this->faker->name(),
            'mobile_number' => $this->faker->phoneNumber(),
            'gst_number' => $this->faker->numerify('################'),
        ];
    }
}
