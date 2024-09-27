<?php

namespace App\Livewire\Traits;

use App\Models\WagerQuestion;
use App\Models\WagerOption;
use App\Models\WagerTeam;
use Illuminate\Support\Collection;
use DateTimeZone;
use Carbon\Carbon;

trait SurvivorTrait
{
    public function allGames($week)
    {

        $ScheduleIds = WagerQuestion::where('week', $week)->pluck('game_id')->toArray();
        $Teams = WagerOption::WhereIn('game_id', $ScheduleIds)->get();
        $Games = WagerQuestion::WhereIn('game_id', $ScheduleIds)->get();

        $options = collect();
        foreach ($Games as $game) {
            $teamIds = $game->gameoptions()->pluck('team_id');
            $teamInfo = WagerTeam::whereIn('team_id', $teamIds)->select('abbreviation', 'name','team_id')->get();

            $combinedData = collect([
                'game' => $game->question,
                'starts' => $game->starts_at,
                'gid' => $game->game_id,
                'mid' => $game->id,
                'info' => $teamInfo,

            ]);
            $options->push($combinedData);
        }
        return [$Games, $options->toArray()];
    }

    public function pickemGames($week)
    {

        $games = WagerQuestion::Where('week', $week)->get();
        $combinedData = collect();
        $keys = $games->pluck('game_id');
        foreach ($games as $game) {
            foreach ($game->gameoptions as $go) {
                $teamType = $go->home_team ? 'home' : 'away';
                if($go->home_team === 1) {
                    $homeTeamInfo = $go->teaminfo;
                } elseif($go->home_team === 0) {
                    $awayTeamInfo = $go->teaminfo;
                }
                $tmz = (object) [
                        'home' => $homeTeamInfo ?? $awayTeamInfo,
                        'away' => $awayTeamInfo,
                ];
            }

            $item = (object)[
                'game' => $game->question,
                'starts' => $game->begins->format('l F jS g:iA T'),
                'gid' => $game->game_id,
                'mid' => $game->id,
                'teams' => $tmz,
                'result' => $game->result,
            ];

            $combinedData->push($item);
        }

        $combined = collect($keys)->combine($combinedData);

        return $combined;
    }



    public function decipherWeek()
    {

        $dateRanges = [
            ['start' => '2024-09-05', 'end' => '2024-09-09'],
            ['start' => '2024-09-10', 'end' => '2024-09-16'],
            ['start' => '2024-09-17', 'end' => '2024-09-23'],
            ['start' => '2024-09-24', 'end' => '2024-09-30'],
            ['start' => '2024-10-01', 'end' => '2024-10-07'],
            ['start' => '2024-10-08', 'end' => '2024-10-14'],
            ['start' => '2024-10-15', 'end' => '2024-10-21'],
            ['start' => '2024-10-22', 'end' => '2024-10-28'],
            ['start' => '2024-10-29', 'end' => '2024-11-05'],
            ['start' => '2024-11-06', 'end' => '2024-11-11'],
            ['start' => '2024-11-12', 'end' => '2024-11-18'],
            ['start' => '2024-11-19', 'end' => '2024-11-25'],
            ['start' => '2024-11-26', 'end' => '2024-12-02'],
            ['start' => '2024-12-03', 'end' => '2024-12-09'],
            ['start' => '2024-12-10', 'end' => '2024-12-16'],
            ['start' => '2024-12-17', 'end' => '2024-12-23'],
            ['start' => '2024-12-24', 'end' => '2024-12-30'],
            ['start' => '2025-12-31', 'end' => '2025-01-01'],
        ];

        $now = date('Y-m-d'); // Current date, can be customized
        $week = 1;
        foreach ($dateRanges as $i => $range) {
            if ($now >= $dateRanges[$i]['start'] && $now <= $dateRanges[$i]['end']) {
                $week = $i + 1;
            }
        }

        return $week;
    }


    public function isLive($week, $pick): bool
    {
        //return false;
        $currentTimeEST = now();

        $locateSelection = WagerOption::with('question')
            ->where('week', $week)
            ->where('option', $pick)
            ->first();

        return $currentTimeEST->lessThan($locateSelection->question->starts_at->addMinutes(5));

    }

    public function fetchSurvivorPicks()
    {
        $keys = $games->pluck('game_id');
        $combined = collect($keys)->combine($combinedData);
    }
}
