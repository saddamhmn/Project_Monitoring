<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'              => 'Super Admin',
                'email'             => 'superadmin@gmail.com',
                'password'          => Hash::make('password'),
                'role'              => 'superadmin',
                'email_verified_at' => now(),
            ],
            [
                'name'              => 'Manajer',
                'email'             => 'manajer@gmail.com',
                'password'          => Hash::make('password'),
                'role'              => 'manajer',
                'email_verified_at' => now(),
            ],
            [
                'name'              => 'Petugas',
                'email'             => 'petugas@gmail.com',
                'password'          => Hash::make('password'),
                'role'              => 'petugas',
                'email_verified_at' => now(),
            ],
            [
                'name'              => 'Security',
                'email'             => 'security@gmail.com',
                'password'          => Hash::make('password'),
                'role'              => 'security',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(
                ['email' => $user['email']],
                $user
            );
        }

        $this->command->info('✓ Users seeded (4 akun: superadmin, manajer, petugas, security)');
    }
}