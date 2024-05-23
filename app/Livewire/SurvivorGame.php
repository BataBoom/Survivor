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

    public $survivor;
    public $currentTimeEST;

    public bool $duplicataes = false;

    public $mypicks;

    public $week;
    public $choice = '';

    public $choices;
    public $pickteam;
    public $delteam;
    public $newweek;

    public $whatweek;
    public $currentPool;
    public $bl;
    public $status;
    public User $user;
    public $selectedweek;

    public $rules = [
        'pickteam' => 'required|array',
        'delteam' => 'required|array',
    ];

    /* Survivor & currentPool are mounted from view */
    public function mount()
    {
        //Sub 30 mins for security..
        $this->currentTimeEST = Carbon::now(new DateTimeZone('America/New_York'))->subMinutes(30);

        //dd([$this->survivor, $this->currentPool]);
        $this->user = Auth::user();
        $this->newweek = $this->decipherWeek();
        $this->whatweek = $this->decipherWeek();

        $this->hasDupes();

        $this->week = $this->newweek ?? $this->decipherWeek();
        $this->status = $this->status();
        $this->choices = $this->teamsLeft($this->week);
        $this->mypicks = $this->survivor->survivorPicks;

    }

    public function changeWeek()
    {
        $this->week = $this->newweek ?? $this->decipherWeek();
    }

    public function status()
    {
        return $this->survivor->where('alive',1)->exists() ? true : false;
    }

    public function hasDupes()
    {
        $selections = $this->survivor->picks->pluck('selection');
        // Find duplicate selections
        $duplicateSelections = $selections->duplicates();

        $this->duplicataes = $duplicateSelections->isNotEmpty();
    }


    public function hydrate() {
        //$this->reset('week');
        //$this->changeWeek();
        //$this->teamsLeft($this->week);
        //$this->biggestLoser($this->week);
        $this->mypicks = $this->picked();
       // $this->hasDupes();
    }

    public function UpdatedWeek()
    {
        //$this->allGames = $this->pickemGames($this->week);
        //$this->teamsLeft($this->week);


    }
    public function UpdatedNewweek()
    {
        $this->week = $this->newweek ?? $this->decipherWeek();
        //$this->teamsLeft($this->week);
        $this->mypicks = $this->picked();
    }


    public function isAllowed($pick) {

        $this->selectedweek = $this->newweek ?? $this->decipherWeek();

        //Determine if user has placed this pick before, and if he has it hasnt been graded yet.
        $status = $this->survivor->picks()->where('selection', $pick)->whereNotNull('result')->doesntExist();

        //Locate the game and ensure it hasnt started yet.
        if($status) {

            $locateSelection = WagerOption::with('question')
                ->where('week', $this->selectedweek)
                ->where('option', $pick)
                ->first();

            $isLive = $this->currentTimeEST->lessThan($locateSelection->question->starts_at->subMinutes(30));

            $message = "success";

        } else {

            $message = "You've already used this team, and the match has been graded.";
        }

        if($status && !$isLive) {
            $message = "Match started, cannot update pick!";
            $status = false;
        }

        return [$status, $message];

    }

    #[Renderless]
    public function RemovePick($pick, $week) {

        $isAllowed = $this->isAllowed($pick);
        $status = $isAllowed[0];
        if($status && $this->status()) {

            if($this->survivor->picks()->where(['selection' => $pick, 'week' => $week])->delete()) {

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

    public function submit()
    {

        $this->validateOnly('pickteam');

        //safe-guard, works, but may move
        //$this->authorize('update', $this->survivor);

        $status  = $this->isAllowed($this->pickteam[0]);

        if($status && $this->status()) {



            $locateSelection = WagerOption::with('question')
                ->where('week', $this->selectedweek)
                ->where('option', $this->pickteam[0])
                ->first();

            try {
                Survivor::updateOrCreate(
                    ['week' => $this->selectedweek, 'user_id' => $this->user->id, 'pool_id' => $this->currentPool->id],
                    [
                        'game_id' => $locateSelection->game_id,
                        'selection_id' => $locateSelection->team_id,
                        'selection' => $locateSelection->option,
                        'pool_id' => $this->currentPool->id,
                    ]
                );

                $this->toast(
                    type: 'success',
                    title: 'Added! Week ' . $this->selectedweek.' - '.$this->pickteam[0],
                    description: null,                  // optional (text)
                    position: 'toast-top toast-end',    // optional (daisyUI classes)
                    icon: 'o-information-circle',       // Optional (any icon)
                    css: 'alert-info',                  // Optional (daisyUI classes)
                    timeout: 3000,                      // optional (ms)
                    redirectTo: null                    // optional (uri)
                );




            } catch (Exception $e) {

                $this->error(
                    'Cannot select ' . $this->pickteam[0]. '. Check your selections and try again...',
                    timeout: 3000,
                    position: 'toast-top toast-end'
                );
            }

            $this->week = $this->newweek ?? $this->decipherWeek();

        }

    }

    #[Renderless]
    public function getGames($week)
    {
        return WagerQuestion::all()->where('week', $week);
    }


    public function picked()
    {
        /*
       // $this->mypicks = $this->survivor->survivorPicks;
        $pickedTeams = $this->survivor->survivorPicks->pluck('selection_id')->toArray();
        $picked = WagerTeam::whereIn('team_id', $pickedTeams)->get();

        return $picked;
        */
        return $this->survivor->survivorPicks;
    }

    public function teamsLeft($week)
    {

        $picked = $this->survivor->survivorPicks->whereNotNull('result')->pluck('selection_id')->toArray();

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

    #[Renderless]
    public function lastPick()
    {

        $last = Survivor::getLastPickByUser(Auth::user(), $this->currentPool->id);
        if($last) {
            return array($last->week => $last->selection);
        } else {
            return [];
        }


    }

    #[Renderless]
    public function deleteablePicks() {

        return $this->survivor->picks->whereNull('result');

    }

    public function biggestLoser($week)
    {

        $lw = $week - 1;

        $biggestLoser = Survivor::Where('week', $lw)->where('result', false)->where('pool_id', $this->currentPool->id)->select('selection')->get();

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

        $playerCount = ['Alive'=> SurvivorRegistration::Where('alive', 1)->where('pool_id', $this->currentPool->id)->count(), 'Dead' => SurvivorRegistration::Where('alive', 0)->where('pool_id', $this->currentPool->id)->count()];

        return $playerCount;
    }


    public function render()
    {
      //dd($this->survivor->survivorPicks);
        return view('livewire.survivor-game', [
            //'allGames' => $this->allGames($this->week),
            //'games' => $this->getGames($this->week),
            //'teams' => $this->teams($this->week),
            //'picked' => $this->picked(),
            //'latestpick' => $this->lastPick(),
            //'delPicks' => $this->deleteablePicks(),
            //'choices' => $this->teamsLeft($this->week),
            //'whatweek' => $this->decipherWeek(),
            //'week' => $this->changeWeek(),
            'biggestLoser' => $this->biggestLoser($this->week),
            'status' => $this->status,
            'playerCount' => $this->playerCount(),

        ]);
    }
}