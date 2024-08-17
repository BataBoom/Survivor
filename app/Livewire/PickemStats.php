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

    public function mount()
    {
        $this->user = Auth::User();
        $this->week = 1;
        $this->whatweek = $this->decipherWeek();
        $this->contender = $this->pool?->contenders?->where('user_id', $this->user->id)->first();
        $this->leaderboard = $this->fetchLeaderboard();

    }

    public function fetchLeaderboard()
    {
        $leader = collect();

        foreach($this->pool->contenders as $contender) {
            $leader->push((object)[
                'user' => $contender->user,
                'record' => $contender->pickems->whereNotNull('result')->countBy(function ($model) {
                    return $model->result ? 'Won' : 'Lost';
                }),
            ]);
        }

        $sortedLeaders = $leader->sortByDesc(function ($item) {
            return $item->record->get('Won', 0);
        });
        $sortedLeaders = $sortedLeaders->values();

        $sortedLeaders->map(function ($item, $index) {
            $item->rank = $index + 1;
            return $item;
        });

        $yourRank = $sortedLeaders->where('user', $this->user)->first() ?? null;

        if($yourRank) {
            $top5 = $sortedLeaders->take(3);
            $top5->push($yourRank);
        }

        return $top5;
    }

    public function leaderboardSetup()
    {
        $leader = collect();

        foreach($this->pool->contenders as $contender) {
            $leader->push((object)[
                'user' => $contender->user,
                'record' => $contender->pickems->whereNotNull('result')->countBy(function ($model) {
                    return $model->result ? 'Won' : 'Lost';
                }),
            ]);
        }

        $sortedLeaders = $leader->sortByDesc(function ($item) {
            return $item->record->get('Won', 0);
        });
        $sortedLeaders = $sortedLeaders->values();

        $sortedLeaders->map(function ($item, $index) {
            $item->rank = $index + 1;
            return $item;
        });

        

        return $sortedLeaders->take(5);
    }

    public function render()
    {  
        //dd($this->leaderboard);
        $pickems = PickemModel::Where('ticket_id', $this->contender->id)
                    ->orderBy('week', 'asc')
                    ->paginate(10);
        //dd($this->leaderboardSetup());

        return view('livewire.pickem-stats', ['pickems' => $pickems]);
    }
}
