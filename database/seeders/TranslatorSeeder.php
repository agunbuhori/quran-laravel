<?php

namespace Database\Seeders;

use App\Models\Translator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TranslatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Translator::insert([
            [
                'title'       => 'King Fahad Quran Complex',
                'author_name' => 'King Fahad Quran Complex',
                'lang'        => 'id',
            ],
            [
                'title'       => 'The Sabiq company',
                'author_name' => 'The Sabiq company',
                'lang'        => 'id',
            ],
            [
                'title'       => 'Abdullah Muhammad Basmeih',
                'author_name' => 'Abdullah Muhammad Basmeih',
                'lang'        => 'ms',
            ],
            [
                'title'       => 'Sahih International',
                'author_name' => 'Sahih International',
                'lang'        => 'en',
            ],
            [
                'title'       => 'Thai Translatio (King Fahad Quran Complex)',
                'author_name' => 'King Fahad Quran Complex',
                'lang'        => 'th',
            ],
            [
                'title'       => 'Hasan Abdul-Karim',
                'author_name' => 'Hasan Abdul-Karim',
                'lang'        => 'vi',
            ],
        ]);
    }
}
