<?php

namespace Database\Factories;

use App\Models\UserNotification;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserNotificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserNotification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 20,
            'title' => $this->faker->text(10),
            'text' => $this->faker->text(100),
            'seen' => '0',
        ];
    }
}
