<?php

namespace Database\Seeders;

use App\Models\Balance;
use App\Models\Operation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;


class OperationAndBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $balances = [];// Array for users balance

        // Add 20 operations
        for ($i = 1; $i <= 100; $i++) {
            $userId = $faker->numberBetween(1, 11);

            if (!isset($balances[$userId])) {
                $balances[$userId] = 0;
            }

            $amount = $faker->randomFloat(2, -10, 10);

            if ($balances[$userId] + $amount < 0) {
                $amount = abs($balances[$userId]) + $faker->randomFloat(2, 0, 10.99);
            }

            Operation::create([
                'user_id' => $userId,
                'amount' => $amount,
                'description' => $faker->sentence(),
            ]);

            $balances[$userId] += $amount;
        }

        // Add users balance
        foreach ($balances as $userId => $balance) {
            Balance::create([
                'user_id' => $userId,
                'balance' => $balance
            ]);
        }
    }
}
