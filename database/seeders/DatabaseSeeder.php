<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'firstname' => 'Janos',
            'lastname' => 'Stelli',
            'email' => 'stellijanos23@gmail.com',
            'phone' =>'0712345678',
            'email_verified_at' => now(),
            'password' => '$2y$12$AIux9tECdZA3Pi2Wtk6WFelKUXwYmMzrhE6qXWsPm/GM9q9R7l0Bi',
            'role' => 'admin'
        ]);
    }
}
