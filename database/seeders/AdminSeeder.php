<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Propaganistas\LaravelPhone\PhoneNumber;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phone = new PhoneNumber('0500243492', 'UA');

        User::firstOrCreate([
            'phone' => $phone,
        ], [
            'email' => 'test@gmail.com',
            'role' => RoleEnum::ADMIN,
            'name' => 'Admin',
            'password' => 'test123!'
        ]);
    }
}
