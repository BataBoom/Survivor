<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\WagerQuestion;
use App\Models\WagerOption;
use App\Models\WagerTeam;
use App\Models\Survivor;
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

class SurvivorGame extends Component
{
    use Toast, SurvivorTrait;

    public SurvivorRegistration $survivor;

    public User $user;

    public Pool $pool;
    public $currentTimeEST;

    public $week;

    public $realWeek;

    public $mypicks;

    public $choices;

    public $selectTeam = '';

    public $delteam;




    /* Survivor & currentPool are mounted from view */
    public function mount()
    {
        //Sub 30 mins for security..
        $this->currentTimeEST = Carbon::now(new DateTimeZone('America/New_York'))->subMinutes(30);

        $this->user = Auth::User();

        $this->week = $this->decipherWeek();

        //$this->realWeek = $this->decipherWeek();
        $this->realWeek = 1;

        $this->survivor = $this->pool?->contenders->where('user_id', $this->user->id)->first();
        $this->mypicks = $this->survivor->survivorPicks()->get();

        $this->choices = $this->teamsLeft($this->week);


    }

    public $rules = [
        'selectTeam' => 'required|string',
        'delteam' => 'required|array',
    ];

    public function UpdatedWeek()
    {
        $this->choices = $this->teamsLeft($this->week);
        $this->reset('selectTeam');
    }

    public function teamsLeft($week)
    {

        $picked = $this->mypicks->pluck('selection_id')->toArray();

        $ScheduleIds = WagerQuestion::where("week", $week)
            ->where('starts_at', '>', $this->currentTimeEST)
            ->pluck('game_id')->toArray();

        $Teams = WagerOption::WhereIn('game_id', $ScheduleIds)->get();

        $options = collect();
        foreach ($Teams as $team) {
            $options->push(collect($team->teaminfo));
        }

        $filteredCollection = $options->whereNotIn('team_id', $picked);
        $sortedCollection = $filteredCollection->sortBy('name');

        return $sortedCollection->all();
    }

    public function changeWeek()
    {
        $this->biggestLoser($this->week);
        $this->choices = $this->teamsLeft($this->week);
    }

    public function hydrate() {
        $this->biggestLoser($this->week);
        $this->choices = $this->teamsLeft($this->week);

        //$this->mypicks = $this->survivor->survivorPicks()->get();
        //$this->choices = $this->teamsLeft($this->week);
    }


    public function submit() {


        $this->validateOnly('selectTeam');

        $isAllowed = $this->isAllowed($this->selectTeam);
        $status = $isAllowed[0];

        if($status) {

            $locateSelection = WagerOption::with('question')
                ->where('week', $this->week)
                ->where('option', $this->selectTeam)
                ->first();

            try {

                $this->survivor->survivorPicks()->updateOrCreate(
                    ['week' => $locateSelection->week, 'user_id' => $this->user->id, 'ticket_id' => $this->survivor->id],
                    [
                        'game_id' => $locateSelection->game_id,
                        'selection_id' => $locateSelection->team_id,
                        'selection' => $locateSelection->option,
                    ]
                );

                $this->toast(
                    type: 'success',
                    title: 'Added! Week ' . $this->week . ' - ' . $this->selectTeam,
                    description: null,                  // optional (text)
                    position: 'toast-top toast-end',    // optional (daisyUI classes)
                    icon: 'o-information-circle',       // Optional (any icon)
                    css: 'alert-info',                  // Optional (daisyUI classes)
                    timeout: 3000,                      // optional (ms)
                    redirectTo: null                    // optional (uri)
                );

            } catch (Exception $e) {
                report($e);
                $this->error(
                    'Cannot select ' . $this->selectTeam . '. Check your selections and try again...',
                    timeout: 3000,
                    position: 'toast-top toast-end'
                );
            }

        } else {
            $this->error(
                'Cannot select ' . $this->selectTeam,
                description: $isAllowed[1],
                timeout: 3000,
                position: 'toast-top toast-end'
            );
        }


        $this->mypicks = $this->survivor->survivorPicks()->get();
        $this->choices = $this->teamsLeft($this->week);
        $this->reset('selectTeam');

    }


    public function isAllowed($pick) {

        //Determine if user has placed this pick before, and if he has it hasnt been graded yet.
        $status = $this->survivor->survivorPicks()->where('selection', $pick)->whereNotNull('result')->doesntExist();

        //Locate the game and ensure it hasnt started yet.
        if($status) {

            $locateSelection = WagerOption::with('question')
                ->where('week', $this->week)
                ->where('option', $pick)
                ->first();

            $isLive = $this->currentTimeEST->lessThan($locateSelection->question->starts_at->subMinutes(30));

            $message = "success";

        } else {

            $message = "Game Started.";
        }

        if($status && !$isLive) {
            $message = "Match started, cannot update pick!";
            $status = false;
        }

        //dd([$status, $message]);
        return [$status, $message];

    }

    public function RemovePick($pick, $week) {

        $isAllowed = $this->isAllowed($pick);
        $status = $isAllowed[0];

        if($status) {

            if($this->survivor->survivorPicks()->where(['selection' => $pick, 'week' => $week])->delete()) {

                $this->choices = $this->teamsLeft($this->week);
                $this->mypicks = $this->survivor->survivorPicks()->get();

                $this->toast(
                    type: 'success',
                    title: $pick.' Removed',
                    description: 'Week: '.$week,                  // optional (text)
                    position: 'toast-top toast-end',    // optional (daisyUI classes)
                    icon: 'o-information-circle',       // Optional (any icon)
                    css: 'alert-info',                  // Optional (daisyUI classes)
                    timeout: 3000,                      // optional (ms)
                    redirectTo: null                    // optional (uri)
                );
            }

        } else {

            $this->error(
                'Cannot remove' . $pick,
                description: $isAllowed[1],
                timeout: 3000,
                position: 'toast-top toast-end'
            );
        }




    }

    public function biggestLoser($week)
    {

        $lw = $week - 1;

        $biggestLoser = Survivor::Where('week', $lw)->where('result', false)->where('ticket_id', $this->survivor->id)->select('selection')->get();

        if($biggestLoser->count() >= 1) {
            $selectionCount = [];


            foreach ($biggestLoser as $item) {
                $selection = $item->selection;


                if (isset($selectionCount[$selection])) {
                    $selectionCount[$selection]++;
                } else {
                    $selectionCount[$selection] = 1;
                }
            }

            arsort($selectionCount); // sort the selection count in descending order

            $mostUsedSelection = key($selectionCount); // get the most used selection


            $bl = [$selectionCount[$mostUsedSelection] => $mostUsedSelection];

        }

        return $bl ?? null;
    }

    #[Renderless]
    public function playerCount() {

        $playerCount = ['Alive'=> SurvivorRegistration::Where('alive', 1)->where('pool_id', $this->pool->id)->count(), 'Dead' => SurvivorRegistration::Where('alive', 0)->where('pool_id', $this->pool->id)->count()];

        return $playerCount;
    }


    public function render()
    {
        //dd($this->mypicks);
        //dd($this->survivor->survivorPicks);
        return view('livewire.survivor-game', [
            'biggestLoser' => $this->biggestLoser($this->week),
            'playerCount' => $this->playerCount(),

        ]);
    }
}