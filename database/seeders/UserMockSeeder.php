<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserMockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'teste@admin.com'], 
            [
                'name' => 'Usuário Teste Admin',
                'email' => 'teste@admin.com',
                'password' => Hash::make('123456'), 
                'email_verified_at' => now(),
            ]
        );
    }
}
