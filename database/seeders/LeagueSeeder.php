<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sport;
use App\Models\League;

class LeagueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $sports = [
          ['name' => 'American Football', 'leagues' => ['NFL', 'NCAAF']],
          ['name' => 'World Football', 'leagues' => ['Bundesliga']],
          ['name' => 'Baseball', 'leagues' => ['MLB']],
          ['name' => 'Ice Hockey', 'leagues' => ['NHL']],
          ['name' => 'Basketball', 'leagues' => ['NBA']],
          ['name' => 'Mixed Martial Arts', 'leagues' => ['UFC', 'PFL']],
        ];

        $sportName = array_column($sports, 'name');
        $leagues = array_column($sports, 'leagues');

        $sportsModal = Sport::WhereIn('name', $sportName)
          ->get()
          ->toArray();

        foreach ($sportsModal as $k => $v) {
          $sportsModal[$k]['leagues'] = $leagues[$k];
        }

        $leagues = [];
        foreach ($sportsModal as $sport) {
          foreach ($sport['leagues'] as $league) {

                $leagues[$sport['name']][] = [$league, $sport['id']];

                League::Create([
                      'name' => $league,
                      'sport_id' => $sport['id'],
                    ]);
            }
        }
    }
}
