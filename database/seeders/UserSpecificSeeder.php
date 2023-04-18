<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSpecificSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Promed Planet',
            'email' => 'admin@promedplanet.com',
            'username' => 'promedplanet',
            'email' => 'admin@promedplanet.com',
            'password' => bcrypt('password'),
        ]);
    }
}
