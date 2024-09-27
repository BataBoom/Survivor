<?php

namespace App\Livewire;

use App\Livewire\Traits\SurvivorTrait;
use App\Models\SurvivorRegistration;
use Livewire\Component;
use Mary\Traits\Toast;
use App\Models\Pool;
use App\Models\Pickem as PickemModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PickemStats extends Component
{
    use Toast, SurvivorTrait;

    public $user;

    public $week;
    public SurvivorRegistration $contender;

    public Pool $pool;
    public $whatweek;
    public $yourRank;
    public $leaderboard;
    public $poolFavTeams;
    public $myFavTeams;
    public $mycard;

    public function mount()
    {
        $this->user = Auth::User();
        $this->week = 3;
        $this->whatweek = $this->decipherWeek();
        $this->contender = $this->pool?->contenders?->where('user_id', $this->user->id)->first();
        $this->leaderboard = $this->fetchLeaderboard();
        $this->poolFavTeams = $this->poolsFavTeams();
        $this->myFavTeams = $this->MyFavTeams();
        $this->mycard = $this->fetchMyCard();

    }

    public function fetchLeaderboard()
    {
        $leader = collect();

        foreach ($this->pool->contenders as $contender) {

        $mostUsedDivision = $contender->pickems->whereNotNull('result')->map(function ($group) {
        return $group->team->division;
        })->countBy()->sortDesc();

        $mostUsed = $contender->pickems->whereNotNull('result')->map(function ($group) {
        return $group->selection;
        })->countBy()->sortDesc();


            $leader->push((object)[
                'user' => $contender->user->name,
                'record' => collect(['Won' => 0, 'Lost' => 0])->merge(
                    $contender->pickems->whereNotNull('result')->countBy(function ($model) {
                        return $model->result ? 'Won' : 'Lost';
                    })
                ),
                'conferenceRecord' => $contender->pickems
                    ->whereNotNull('result')
                    ->countBy(function ($model) {
                      return $model->team->conference === 'NFC' ? 'NFC' : 'AFC';
                    }),
                'NFC_Record' => collect(['Won' => 0, 'Lost' => 0])->merge(
                    $contender->pickems
                    ->whereNotNull('result')
                    ->where('team.conference', 'NFC')
                    ->countBy(function ($model) {
                      return $model->result ? 'Won' : 'Lost';
                    })),
                'AFC_Record' => collect(['Won' => 0, 'Lost' => 0])->merge($contender->pickems
                    ->whereNotNull('result')
                    ->where('team.conference', 'AFC')
                    ->countBy(function ($model) {
                      return $model->result ? 'Won' : 'Lost';
                    })),
                'TopPickedTeams' => $mostUsed,
                'TopPickedDivisons' => $mostUsedDivision,
            ]);
        }

        $sortedLeaders = $leader->sortByDesc(function ($item) {
            return $item->record->get('Won', 0);
        })->values();

        $leader = $sortedLeaders->map(function ($item, $index) {
            $item->rank = $index + 1;
            return $item;
        });

        $yourRank = $sortedLeaders->where('user', $this->user->name)->first() ?? null;
        
        $top5 = $leader->take(10);
        if($yourRank) {
            $top5 = $top5->push($yourRank);
        }

        /*
        Log::debug('Sorted Leader Count: ' . $sortedLeaders->count());
        Log::debug('Leader Count: ' . $leader->count());
        Log::debug('Top5 Count: ' . $top5->count());
        */

        return $top5;
    }

    public function leaderboardSetup()
    {
        $leader = collect();

        foreach ($this->pool->contenders as $contender) {
            $leader->push((object)[
                'user' => $contender->user->id,
                'record' => collect(['Won' => 0, 'Lost' => 0])->merge(
                    $contender->pickems->whereNotNull('result')->countBy(function ($model) {
                        return $model->result ? 'Won' : 'Lost';
                    })
                ),
            ]);
        }

        $sortedLeaders = $leader->sortByDesc(function ($item) {
            return $item->record->get('Won', 0);
        })->values();

        $leader = $sortedLeaders->map(function ($item, $index) {
            $item->rank = $index + 1;
            return $item;
        });

        $top10 = $leader->take(10);
        
        return $top10;
    }

    public function poolsFavTeams()
    {

        $topPlayers = $this->leaderboardSetup();

        $top10PickemTeams = PickemModel::WhereIn('user_id', $topPlayers->pluck('user')->toArray())
              ->whereNotNull('result')
              ->get();

        $favteams = collect();

        $top10PickemTeams->groupBy('selection_id')
            ->each(function ($group) use($favteams) {
                $firstItem = $group->first();
                    $favteams->push((object)[
                        'team' => $firstItem->team,
                        'team_id' => $firstItem->selection_id,
                        'count' => $group->count(),
                        'wins' => $group->where('result', 1)->count(),
                        'losses' => $group->where('result', 0)->count(),
                    ]);    
            });

            return $favteams->sortByDesc('count');
    }

    
    public function MyFavTeams()
    {

        $favteams = collect();

        $myTopTeams = PickemModel::Where('user_id', $this->user->id)
              ->whereNotNull('result')
              ->get();

        if($myTopTeams) {
            $myTopTeams->groupBy('selection_id')
                ->each(function ($group) use($favteams) {
                    $firstItem = $group->first();
                    $favteams->push((object) [
                        'team' => $firstItem->team,
                        'team_id' => $firstItem->selection_id,
                        'count' => $group->count(),
                        'wins' => $group->where('result', 1)->count(),
                        'losses' => $group->where('result', 0)->count(),
                    ]);    
                });
            return $favteams->sortByDesc('count');
        }

        return $favteams;
    }

    public function fetchMyCard()
    {

        $cards = $this->fetchLeaderboard();

        return $cards->where('user', $this->user->name)->first() ?? null;
    }
    

    public function render()
    {  
        //dd($this->leaderboard);
        $pickems = PickemModel::Where('ticket_id', $this->contender->id)
                    ->orderBy('week', 'desc')
                    ->whereNotNull('result')
                    ->paginate(16);
        //dd($this->leaderboardSetup());

        return view('livewire.pickem-stats', ['pickems' => $pickems]);
    }
}
