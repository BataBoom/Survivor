<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pool;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SportSeeder::class,
            LeagueSeeder::class,
            WagerTeamsSeeder::class,
            SurvivorScheduleSeeder::class,
            CreateDummyPools::class,
            AdminUserSeeder::class,
        ]);
    }
}
