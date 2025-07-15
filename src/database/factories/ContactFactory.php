<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class ContactFactory extends Factory
{
    public function definition()
    {
        $categoryIds = Category::pluck('id')->all();

        return [
            'last_name'   => $this->faker->lastName,
            'first_name'  => $this->faker->firstName,
            'gender'      => $this->faker->randomElement(['男性', '女性', 'その他']),
            'email'       => $this->faker->unique()->safeEmail,
            'tel'         => $this->faker->numerify('0##########'), // 10～11桁
            'address'     => $this->faker->address,
            'building'    => $this->faker->optional()->secondaryAddress,
            'category_id' => $this->faker->randomElement($categoryIds),
            'content'     => $this->faker->realText(60),
        ];
    }
}
