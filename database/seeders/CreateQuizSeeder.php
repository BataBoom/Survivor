<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\QuizOption;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\WagerTeam;

class CreateQuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $NFLTeams = WagerTeam::Where('league_id', 1)->get();

        $quiz = Quiz::Find(1);

        foreach($NFLTeams as $team) {

            $divisions = [
                ['option' => 'AFC East'],
                ['option' => 'AFC North'],
                ['option' => 'AFC South'],
                ['option' => 'AFC West'],
                ['option' => 'NFC East'],
                ['option' => 'NFC North'],
                ['option' => 'NFC South'],
                ['option' => 'NFC West']
            ];

            foreach($divisions as $k => $v) {
                if ($divisions[$k]['option'] === $team->division) {
                    $divisions[$k]['answer'] = 1;
                } else {
                    $division[$k]['answer'] = 0;
                }
            }

            $quiz->questions()->create([
                'question' => 'What division is the '.$team->name.' from?',
            ])->options()->createMany(
                $divisions,
            );
        }
        
    }
}
