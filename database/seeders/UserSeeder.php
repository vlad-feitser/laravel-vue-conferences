<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'firstname' => Str::random(8),
            'lastname' => Str::random(10),
            'email' => Str::random(6).'@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('11111111'),
            'type' => 'Listener',
            'birthdate' => mt_rand(1970, 2010).'-'.mt_rand(1, 12).'-'.mt_rand(1, 28),
            'country' => 'Ukraine',
            'phone' => '095'.mt_rand(0000000, 9999999),
        ]);
    }
}
