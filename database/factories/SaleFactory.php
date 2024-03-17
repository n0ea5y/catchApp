<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Store;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $store = Store::inRandomOrder()->first();

        $deleted_ats = ['1','0'];
        $deleted_at = $deleted_ats[rand(0, count($deleted_ats) - 1)];


        return [
            'users_id' => $user->id,
            'stores_id' => $store->id,
            'customer_payment' => rand(5000, 15000),
            'deleted_at' => $deleted_at,
            'created_date' => Carbon::now(),
        ];
    }
}