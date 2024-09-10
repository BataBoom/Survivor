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

        foreach ($this->pool->contenders as $contender) {
            $leader->push((object)[
                'user' => $contender->user->name,
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
