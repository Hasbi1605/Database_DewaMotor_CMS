<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if not exists
        User::firstOrCreate(
            ['email' => 'admin@dewamotor.com'],
            [
                'name' => 'Administrator',
                'email' => 'admin@dewamotor.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin users created successfully!');
        $this->command->info('Email: admin@dewamotor.com | Password: password');
        $this->command->info('Email: admin@demo.com | Password: 123456');
    }
}
