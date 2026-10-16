<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Panggil seeder kustom kita yang sudah aman dari kolom email_verified_at
        $this->call([
            AdminUserSeeder::class,
            CategoryAndFacilitySeeder::class,
        ]);
    }
}
