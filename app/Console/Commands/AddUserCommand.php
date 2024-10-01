<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Balance;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AddUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:add {name} {email} {password}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');
        DB::beginTransaction();

        try {
            // Check for existence of user with same email
            if (User::where('email', $email)->exists()) {
                throw new \Exception('User with this email already exists.');
            }

            // Create user
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);
            if (!$user) {
                throw new \Exception('Failed to add user.');
            }

            // Create balance
            $balance = Balance::create([
                'user_id' => $user->id,
                'balance' => 0
            ]);
            if (!$balance) {
                throw new \Exception('Failed to create user balance.');
            }

            DB::commit();

            $this->info('User and balance successfully added!');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
