<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
use App\Models\Balance;
use App\Models\Operation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;

class ChangeBalanceOperation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $amount;
    protected $description;

    /**
     * Create a new job instance.
     */
    public function __construct($login, $amount, $description)
    {
        $user = User::where('email', $login)->first();

        $this->userId = $user->id;
        $this->amount = $amount;
        $this->description = $description;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::transaction(function () {
            // Get balance
            $balance = Balance::where('user_id', $this->userId)->first();

            if ($balance && $balance->balance + $this->amount >= 0) {
                // Create operation
                Operation::create([
                    'user_id' => $this->userId,
                    'amount' => $this->amount,
                    'description' => $this->description,
                ]);

                // Update balance
                $balance->balance += $this->amount;
                $balance->save();

                Log::info('Operation completed successfully for user ID ' . $this->userId . '. New balance: ' . $balance->balance);

            } else {
                throw new \Exception('Insufficient funds for user ID ' . $this->userId);
            }
        });

    }
}
