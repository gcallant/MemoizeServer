<?php

namespace Database\Factories;

use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    private $index = -1;
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName,
            'email' => $this->faker->unique()->email,
            'phone' => $this->generateFakeAcceptablePhoneNumber(),
            'passcode' =>$this->faker->numberBetween(0, 999999999),
//            'email_verified_at' => now(),
//            'confirmed' => 1,
        ];
    }

    public function generateFakeAcceptablePhoneNumber() : string
    {
        $numbers = [
            '501-634-7715',
            '501-635-7716',
            '501-636-7715',
            '509-234-7715',
            '509-879-6121',
            '509-879-6122',
            '509-879-6123',
            '509-879-6124',
            '307-634-7715',
            '307-634-7716',
            '307-634-7717',
            '307-634-7718',
            '307-634-7719',
            '307-635-7717',
            '307-635-7718',
            '307-635-7719',
            '509-435-3524',
            '509-869-8721',
            '509-869-8722',
            '509-435-3525',
            '307-636-9794',
        ];

        $this->index++;

        return $numbers[$this->index];
    }
}
