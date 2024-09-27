<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pool;
use App\Models\SurvivorRegistration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Exception;
use Mary\Traits\Toast;
use DateTimeZone;
use Livewire\Attributes\Renderless;
use App\Livewire\Traits\SurvivorTrait;


class Pickem extends Component
{
    use Toast, SurvivorTrait;

    public $user;
    public $week;
    public SurvivorRegistration $contender;
    public Pool $pool;
    public $whatweek;
    public $weekConcluded;
    public $allGames;

    public $mypicks;

    public function mount()
    {
        $this->user = Auth::User();
        $this->week = $this->decipherWeek();
        $this->whatweek = $this->decipherWeek();
        //$this->whatweek = 2;
        //$this->week = 3;
        $this->contender = $this->pool?->contenders?->where('user_id', $this->user->id)->first();
        $this->allGames = $this->pickemGames($this->week);
        $this->mypicks = $this->contender?->pickems?->where('week', $this->week);


    }


    public function pickGame($gameID, $selection, $selectionID)
    {

        if($this->isLive($this->week, $selection)) {

            $this->contender->pickems()->updateOrCreate(
                ['ticket_id' => $this->contender->id,'game_id' => $gameID,'week' => $this->week],
                [
                    'ticket_id' => $this->contender->id,
                    'game_id' => $gameID,
                    'selection' => $selection,
                    'selection_id' => $selectionID,
                    'week' => $this->week,
                    'user_id' => $this->contender->user_id,
                ]
            );

            session()->flash('status'.$gameID, 'Updated Pick');

            $this->mypicks = $this->contender->pickems->where('week', $this->week);

        } else {

            $this->error(
                'Cannot update pick, event started.',
                description: 'Week: '.$this->week.' '.$selection,
                timeout: 3000,
                position: 'toast-top toast-center'
            );

        }

    }

    public function UpdatedWeek()
    {
        $this->allGames = $this->pickemGames($this->week);
        $this->mypicks = $this->contender->pickems->where('week', $this->week);

    }

    public function hydrate() {
        $this->allGames = $this->pickemGames($this->week);
    }

    public function render()
    {

        return view('livewire.pickem');
    }
}
