<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;
    protected static int $phoneSeq = 10000000;

    public function definition(): array
    {
        $phone = '973' . (++static::$phoneSeq);

        return [
            'uuid'              => Str::uuid(),
            'first_name'        => fake()->firstName(),
            'last_name'         => fake()->lastName(),
            'email'             => fake()->unique()->userName() . '_' . time() . rand(100, 999) . '@example.com',
            'phone'             => $phone,
            'email_verified_at' => now(),
            'password'          => static::$password ??= Hash::make('password123'),
            'active'            => true,
            'role_id'           => 3, // Viewer by default
            'remember_token'    => Str::random(10),
        ];
    }

    /**
     * Super Admin role state.
     */
    public function superAdmin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role_id' => 1,
        ]);
    }

    /**
     * Admin role state.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role_id' => 2,
        ]);
    }

    /**
     * Viewer role state.
     */
    public function viewer(): static
    {
        return $this->state(fn (array $attributes) => [
            'role_id' => 3,
        ]);
    }

    /**
     * Inactive user state.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'active' => false,
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
