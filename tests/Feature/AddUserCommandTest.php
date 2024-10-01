<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AddUserCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Add user (correct data)
     */
    public function test_add_user_via_command()
    {
        $this->artisan('user:add', [
            'name' => 'Test User',
            'email' => 'unittest@example.com',
            'password' => 'password'
        ])
            ->expectsOutput('User and balance successfully added!')
            ->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'email' => 'unittest@example.com'
        ]);

        $user = User::where('email', 'unittest@example.com')->first();
        $this->assertDatabaseHas('balances', [
            'user_id' => $user->id,
            'balance' => 0
        ]);
    }

    /**
     * Add user (not correct data)
     */
    public function test_add_user_with_existing_email()
    {
        User::factory()->create([
            'name' => 'Test User 2',
            'email' => 'existing@example.com',
            'password' => 'password2'
        ]);

        $this->artisan('user:add', [
            'name' => 'Test User 3',
            'email' => 'existing@example.com',
            'password' => 'password3'
        ])
            ->expectsOutput('Error: User with this email already exists.')
            ->assertExitCode(1);
    }
}
