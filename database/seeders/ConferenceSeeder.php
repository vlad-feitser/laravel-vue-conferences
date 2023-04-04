<?php

namespace Database\Seeders;

use App\Models\Conference;
use Illuminate\Database\Seeder;

class ConferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Conference::create([
            'title' => 'HTML / CSS',
            'date' => '2022'.'-'.mt_rand(7, 12).'-'.mt_rand(5, 30).' '.mt_rand(16, 19).':30:00',
            'latitude' => mt_rand(1, 50).'.'.mt_rand(00000, 99999),
            'longitude' => mt_rand(1, 50).'.'.mt_rand(00000, 99999),
            'country' => 'Ukraine',
        ]);
    }
}
