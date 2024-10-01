<?php

namespace App\Repository;

use App\Models\Balance;
use App\Models\Operation;
use Illuminate\Support\Facades\Auth;

class FetchDataRepository
{
    /**
     * Get balance and operations by user
     * @return array
     */
    public function getBalanceAndOperation()
    {
        $user = Auth::user();

        $balance = Balance::where('user_id', $user->id)->first();
        $balance = $balance->balance;

        // Get 5 last operations
        $operations = Operation::where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->take(5)
            ->get()
            ->map(function ($operation) {
                return (object) [
                    'description' => $operation->description,
                    'amount' => $operation->amount,
                    'created_at' => $operation->created_at,
                ];
            });

        $balanceAndOperations = [
            'balance' => $balance,
            'operations' => $operations
        ];

        return $balanceAndOperations;
    }

}
