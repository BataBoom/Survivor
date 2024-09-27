<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\WagerResult;

class TestDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            SportSeeder::class,
            LeagueSeeder::class,
            BetTypeSeeder::class,
            WagerTeamsSeeder::class,
            
            TestScheduleSeeder::class,
            TestWagerResultSeeder::class,
        ]);

    }
}
