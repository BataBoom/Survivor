<?php

namespace database\seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WagerTeam;
use App\Models\League;

class WagerTeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        if(WagerTeam::Where('league', 'nfl')->get()->isEmpty()) {
            $file = json_decode(file_get_contents('https://site.api.espn.com/apis/site/v2/sports/football/nfl/teams'), true);

            $NFLTeams = $file['sports'][0]['leagues'][0]['teams'];
            
            foreach($teams as $team)
            {

            WagerTeam::Create([
            'team_id' => $team['team']['id'],
            'name' => $team['team']['displayName'],
            'abbreviation' => $team['team']['abbreviation'],
            'league' => strtolower($file['sports'][0]['leagues'][0]['abbreviation']),
            'color'=> $team['team']['color'],
            'altColor' => $team['team']['alternateColor'],
            'location' => $team['team']['location'],
            'league_id' => League::Where('name', 'NFL')->first()?->id,
            ]);


            }

            WagerTeam::Create([
            'team_id' => 35,
            'name' => 'Tie Game',
            'abbreviation' => 'TIE',
            'league' => null,

            ]);
        }

        if(WagerTeam::Where('league', 'nhl')->get()->isEmpty()) {

            $file = json_decode(file_get_contents('https://site.api.espn.com/apis/site/v2/sports/hockey/nhl/teams'), true);

            $NHLTeams = $file['sports'][0]['leagues'][0]['teams'];


            foreach($NHLTeams as $team)
            {

            WagerTeam::Create([
            'team_id' => $team['team']['id'],
            'name' => $team['team']['displayName'],
            'abbreviation' => $team['team']['abbreviation'],
            'league' => strtolower($file['sports'][0]['leagues'][0]['abbreviation']),
            'color'=> $team['team']['color'],
            'altColor' => $team['team']['alternateColor'],
            'location' => $team['team']['location'],
            'league_id' => League::Where('name', 'NHL')->first()?->id,
            ]);
        

            }
        } 

        if(WagerTeam::Where('league', 'nba')->get()->isEmpty()) {

            $file = json_decode(file_get_contents('https://site.api.espn.com/apis/site/v2/sports/basketball/nba/teams'), true);

            $NBATeams = $file['sports'][0]['leagues'][0]['teams'];


            foreach($NBATeams as $team)
            {

            WagerTeam::Create([
            'team_id' => $team['team']['id'],
            'name' => $team['team']['displayName'],
            'abbreviation' => $team['team']['abbreviation'],
            'league' => strtolower($file['sports'][0]['leagues'][0]['abbreviation']),
            'color'=> $team['team']['color'],
            'altColor' => $team['team']['alternateColor'],
            'location' => $team['team']['location'],
            'league_id' => League::Where('name', 'NBA')->first()?->id,
            ]);
        

            }


        } 

        if(WagerTeam::Where('league', 'mlb')->get()->isEmpty()) {

            $file = json_decode(file_get_contents('https://site.api.espn.com/apis/site/v2/sports/baseball/mlb/teams'), true);

            $MLBTeams = $file['sports'][0]['leagues'][0]['teams'];


            foreach($MLBTeams as $team)
            {

            WagerTeam::Create([
            'team_id' => $team['team']['id'],
            'name' => $team['team']['displayName'],
            'abbreviation' => $team['team']['abbreviation'],
            'league' => strtolower($file['sports'][0]['leagues'][0]['abbreviation']),
            'color'=> $team['team']['color'],
            'altColor' => $team['team']['alternateColor'],
            'location' => $team['team']['location'],
            'league_id' => League::Where('name', 'MLB')->first()?->id,
            ]);
        

            }
        }

        if(WagerTeam::Where('league', 'ncaaf')->get()->isEmpty()) {

            $file = json_decode(file_get_contents('http://site.api.espn.com/apis/site/v2/sports/football/college-football/teams?limit=1000&page=1'), true);

            $NCAAFTeams = $file['sports'][0]['leagues'][0]['teams'];


            foreach($NCAAFTeams as $team)
            {

            WagerTeam::Create([
            'team_id' => $team['team']['id'],
            'name' => $team['team']['displayName'],
            'abbreviation' => $team['team']['abbreviation'],
            'league' => strtolower($file['sports'][0]['leagues'][0]['abbreviation']),
            'color'=> isset($team['team']['color']) ? $team['team']['color'] : null,
            'altColor' => isset($team['team']['alternateColor']) ? $team['team']['alternateColor'] : null,
            'location' => $team['team']['location'],
            'league_id' => League::Where('name', 'NCAAF')->first()?->id,
            ]);
        

            }
        }
    }
}
