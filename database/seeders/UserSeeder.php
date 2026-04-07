<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'operator@vis.com'],
            [
                'name' => 'Operator',
                'password' => Hash::make('operator'),
                'role' => 'operator'
            ]
        );
        User::updateOrCreate(
            ['email' => 'leader@vis.com'],
            [
                'name' => 'Leader',
                'password' => Hash::make('leader'),
                'role' => 'leader'
            ]
        );
        User::updateOrCreate(
            ['email' => 'foreman@vis.com'],
            [
                'name' => 'Foreman',
                'password' => Hash::make('foreman'),
                'role' => 'foreman'
            ]
        );
    }
}
