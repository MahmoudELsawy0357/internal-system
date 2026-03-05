<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // هننادي على الـ UserSeeder اللي فيه الموظفين بتوعنا
        $this->call([
            UserSeeder::class,
        ]);
    }
}