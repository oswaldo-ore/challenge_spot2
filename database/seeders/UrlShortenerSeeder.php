<?php

namespace Database\Seeders;

use Database\Factories\UrlShortenerFactory;
use Illuminate\Database\Seeder;

class UrlShortenerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UrlShortenerFactory::new()->count(10)->create();
    }
}
