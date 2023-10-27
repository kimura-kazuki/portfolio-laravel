<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2023/01/24
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace Database\Factories;

use App\Models\UserLocation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

class UserLocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserLocation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'phone' => $this->faker->phoneNumber(),
            'postal_code' => $this->faker->postcode(),
            // 'prefecture' => $this->faker->prefecture(),
            'prefecture_id' => $this->faker->numberBetween(1, 47),
            'address1' => $this->faker->city() . $this->faker->streetName(),
            'address2' => $this->faker->streetAddress(),
        ];
    }
}
