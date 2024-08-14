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
            ['start' => '2024-09-08', 'end' => '2024-09-12'],
            ['start' => '2024-09-13', 'end' => '2024-09-18'],
            ['start' => '2024-09-19', 'end' => '2024-09-25'],
            ['start' => '2024-09-26', 'end' => '2024-10-02'],
            ['start' => '2024-10-03', 'end' => '2024-10-09'],
            ['start' => '2024-10-10', 'end' => '2024-10-16'],
            ['start' => '2024-10-17', 'end' => '2024-10-21'],
            ['start' => '2024-10-22', 'end' => '2024-10-28'],
            ['start' => '2024-10-29', 'end' => '2024-11-06'],
            ['start' => '2024-11-07', 'end' => '2024-11-13'],
            ['start' => '2024-11-14', 'end' => '2024-11-20'],
            ['start' => '2024-11-21', 'end' => '2024-11-27'],
            ['start' => '2024-11-28', 'end' => '2024-12-04'],
            ['start' => '2024-12-05', 'end' => '2024-12-11'],
            ['start' => '2024-12-12', 'end' => '2024-12-19'],
            ['start' => '2024-12-20', 'end' => '2024-12-25'],
            ['start' => '2024-12-26', 'end' => '2024-12-31'],
            ['start' => '2025-01-01', 'end' => '2025-01-06'],
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

        return $currentTimeEST->lessThan($locateSelection->question->starts_at->subMinutes(30));

    }

    public function fetchSurvivorPicks()
    {
        $keys = $games->pluck('game_id');
        $combined = collect($keys)->combine($combinedData);
    }
}