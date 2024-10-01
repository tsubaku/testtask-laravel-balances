<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Operation;
use App\Models\Balance;
use Illuminate\Support\Facades\DB;

class BalanceOperation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'balance:operate {email} {amount} {description}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Carrying out transactions on the users balance (accrual/debit), without going into the minus';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $login = $this->argument('email');
        $amount = (float)$this->argument('amount');
        $description = $this->argument('description');

        // Check that the amount value is valid
        if (!is_numeric($amount) || $amount == 0) {
            $this->error('Only real transactions please.');
            return 1;
        }
        $amount = (float)$amount;

        // Get user
        $user = User::where('email', $login)->first();
        if (!$user) {
            $this->error('User with this login not found.');
            return 1;
        }

        // Get balance
        $balance = Balance::where('user_id', $user->id)->first();
        if (!$balance) {
            $this->error('Balance not found for user.');
            return 1;
        }

        // Check positive balance
        if ($balance->balance + $amount < 0) {
            $this->error('Operation not possible: balance cannot be negative. Current balance: ' . $balance->balance);
            return 1;
        }

        DB::beginTransaction();

        try {
            // Create operation
            $operation = Operation::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'description' => $description,
            ]);

            if (!$operation) {
                throw new \Exception('Failed to add operation.');
            }

            // Update balance
            $balance->balance += $amount;
            $balance->save();

            DB::commit();

            $this->info('Operation completed successfully. Current balance: ' . $balance->balance);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
    }
}
