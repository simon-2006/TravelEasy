<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@traveleasy.nl'],
            ['name' => 'admin', 'role' => User::ROLE_ADMINISTRATOR, 'password' => 'password']
        );

        User::query()->updateOrCreate(
            ['email' => 'manager@traveleasy.nl'],
            ['name' => 'manager', 'role' => User::ROLE_MANAGER, 'password' => 'password']
        );

        User::query()->updateOrCreate(
            ['email' => 'reisadviseur@traveleasy.nl'],
            ['name' => 'reisadviseur', 'role' => User::ROLE_REISADVISEUR, 'password' => 'password']
        );

        User::query()->updateOrCreate(
            ['email' => 'financieel@traveleasy.nl'],
            ['name' => 'financieel', 'role' => User::ROLE_FINANCIEEL_MEDEWERKER, 'password' => 'password']
        );

        $this->call(BookingSeeder::class);
    }
}
