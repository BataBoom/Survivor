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
            WagerTeamsSeeder::class,
            SurvivorScheduleSeeder::class,
            CreateDummyPools::class,
        ]);

        //Pool::factory(['name' => 'NBZ Pickem', 'entry_cost' => 0])->pickem()->create();

        User::create(['name' => 'admin', 'email' =>  'admin@github.com', 'password' =>  Hash::make(config('survivor.admin_pw')), 'email_verified_at' => now()]);

    }
}
