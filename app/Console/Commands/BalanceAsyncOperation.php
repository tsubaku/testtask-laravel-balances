<?php

namespace App\Console\Commands;

use App\Jobs\ChangeBalanceOperation;
use Illuminate\Console\Command;

class BalanceAsyncOperation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'balanceasync:operate {email} {amount} {description}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Carrying out transactions on the users balance (accrual/debit), without going into the minus (Asynchronously)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $login = $this->argument('email');
        $amount = (float)$this->argument('amount');
        $description = $this->argument('description');

        ChangeBalanceOperation::dispatch($login, $amount, $description);
        $this->info('Operation queued successfully. The balance will be updated asynchronously.');
    }
}
