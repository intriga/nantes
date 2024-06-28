<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PostSeeder::class);

        User::create([
            'name' => 'Intriga',
            'email' => 'admin@demo.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
