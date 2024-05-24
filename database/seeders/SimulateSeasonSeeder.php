<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pool;
use App\Models\User;
use App\Models\Survivor;
use App\Models\WagerResult;
use App\Models\WagerQuestion;
use App\Models\SurvivorRegistration;
use Log;

class SimulateSeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alreadySeeded = WagerResult::All()->isEmpty();

        if ($alreadySeeded) {
            $this->call([
                WagerTeamsSeeder::class,
                SurvivorScheduleSeeder::class,
                TestWagerResultSeeder::class,
            ]);
        }



        $pool = Pool::Factory()->survivor()->create();

        foreach($pool->contenders as $survivorUser)
        {
            for($i = 1; $i < 12; ++$i) {
                $randomWager = WagerQuestion::withWhereHas('gameoptions')
                    ->where('week', $i)
                    ->inRandomOrder()
                    ->first();

                // Log the result of the query
                Log::info('Random Wager:', ['week' => $i, 'randomWager' => $randomWager]);

                // Check if $randomWager is null
                if (is_null($randomWager)) {
                    Log::warning('No WagerQuestion found for week ' . $i);
                    continue;
                }

                // Check if gameoptions is null
                if (is_null($randomWager->gameoptions)) {
                    Log::warning('No gameoptions found for WagerQuestion ID ' . $randomWager->id);
                    continue;
                }

                $randomSelection = $randomWager->gameoptions->random();

                $survivorUser->survivorPicks()->create([
                    'ticket_id' => $survivorUser->id,
                    'week' => $randomWager->week,
                    'user_id' => $survivorUser->user_id,
                    'game_id' => $randomSelection->game_id,
                    'selection_id' => $randomSelection->team_id,
                    'selection' => $randomSelection->option,
                ]);

            }
        }

    }
}
