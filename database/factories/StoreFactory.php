<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    private static $counter = 0; 
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $stores_name = ['韓謝韓激&酔っ来らせ', '天下鳥', 'MAC', 'シャカリキ'];
        $deleted_ats = ['1','0'];

        $store_name = $stores_name[self::$counter];
        $deleted_at = $deleted_ats[rand(0, count($deleted_ats) - 1)];

        self::$counter++;

        if (self::$counter >= count($stores_name)) {
            self::$counter = 0;
        }
        
        return [
            //
            'store_name' => $store_name,
            'deleted_at' => $deleted_at,
        ];
    }
}