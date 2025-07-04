<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah sudah ada user
        if (User::count() == 0) {
            User::create([
                'nama' => 'Administrator',
                'email' => 'admin@laundry.com',
                'password' => Hash::make('admin123'),
            ]);

            $this->command->info('User admin berhasil dibuat!');
            $this->command->info('Email: admin@laundry.com');
            $this->command->info('Password: admin123');
        } else {
            $this->command->info('User sudah ada, seeder tidak dijalankan.');
        }
    }
}
