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
        User::create([
            'name' => 'admin',
            'email' => 'agun@buhori.com',
            'password' => bcrypt('@Aczx26120roe'),
            'email_verified_at' => now()
        ]);
        $this->call([
            SurahSeeder::class,
            TranslatorSeeder::class,
            AyahSeeder::class
        ]);
    }
}
