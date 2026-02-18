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
            $teamInfo = WagerTeam::where('league', 'nfl')->whereIn('team_id', $teamIds)->select('abbreviation', 'name','team_id')->get();

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
            ['start' => '2026-09-05', 'end' => '2026-09-08'],
            ['start' => '2026-09-09', 'end' => '2026-09-15'],
            ['start' => '2026-09-16', 'end' => '2026-09-22'],
            ['start' => '2026-09-23', 'end' => '2026-09-29'],
            ['start' => '2026-09-30', 'end' => '2026-10-06'],
            ['start' => '2026-10-07', 'end' => '2026-10-13'],
            ['start' => '2026-10-13', 'end' => '2026-10-21'],
            ['start' => '2026-10-21', 'end' => '2026-10-28'],
            ['start' => '2026-10-28', 'end' => '2026-11-03'],
            ['start' => '2026-11-03', 'end' => '2026-11-11'],
            ['start' => '2026-11-10', 'end' => '2026-11-18'],
            ['start' => '2026-11-16', 'end' => '2026-11-25'],
            ['start' => '2026-11-25', 'end' => '2026-12-04'],
            ['start' => '2026-11-30', 'end' => '2026-12-11'],
            ['start' => '2026-12-09', 'end' => '2026-12-19'],
            ['start' => '2026-12-20', 'end' => '2026-12-25'],
            ['start' => '2026-12-23', 'end' => '2026-12-31'],
            ['start' => '2026-12-31', 'end' => '2026-04-29'],
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
