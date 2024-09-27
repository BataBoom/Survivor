<?php

namespace database\seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WagerOption;
use App\Models\WagerQuestion;
use Carbon\Carbon;

/* Import NFL Schedule & Schedule Options*/

class TestScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $week = 1; // Initial value of $week
        $year = 2023;


        while ($week < 5) { // Assuming the maximum value of $week is 18

            $file = json_decode(file_get_contents('https://site.api.espn.com/apis/site/v2/sports/football/nfl/scoreboard?seasontype=2&week='.$week.'&dates='.$year), true);

            $events = $file['events'];
            $week = $file['week']['number'];


            foreach ($events as $i => $event) {
                WagerQuestion::Create([
                    'game_id' => $events[$i]['id'],
                    'week' => $week,
                    'league' => 'nfl',
                    'question' => $events[$i]['name'],
                    'starts_at' => Carbon::parse($events[$i]['date'])->format('Y-m-d H:i:s'),
                    //'home_team' =>
                    //'away_team' =>
                    'status' => 0,
                ]);

                /* home teams */
                WagerOption::Create([
                    'game_id' => $events[$i]['id'],
                    'team_id' => $events[$i]['competitions'][0]['competitors'][1]['id'],
                    'option' => $events[$i]['competitions'][0]['competitors'][1]['team']['displayName'],
                    'status' => 1,
                    'week' => $week,
                    'home_team' => false
                ]);

                /* Away teams */
                WagerOption::Create([
                    'game_id' => $events[$i]['id'],
                    'team_id' => $events[$i]['competitions'][0]['competitors'][0]['id'],
                    'option' => $events[$i]['competitions'][0]['competitors'][0]['team']['displayName'],
                    'status' => 1,
                    'week' => $week,
                    'home_team' => true
                ]);
            }

            $week++; // Increase the value of $week by one
        }
    }
}