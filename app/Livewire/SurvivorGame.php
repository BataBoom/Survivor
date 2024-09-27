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
use Livewire\Attributes\Renderless;
use App\Livewire\Traits\SurvivorTrait;
use Illuminate\Validation\Rule;
use App\Rules\BeforeWagerQuestionStart;
use Illuminate\Support\Facades\Validator;
use App\Rules\NotTrueOrFalse;

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

    public $selectTeam;

    public string $selectTeamName = '';

    public $delteam;

    /* Pool is mounted from controller */
    public function mount()
    {
        //Sub 30 mins for security..
        $this->currentTimeEST = Carbon::now();

        $this->user = Auth::User();

        //$this->week = 2;
        $this->week = $this->decipherWeek();
        $this->realWeek = $this->decipherWeek();
        //$this->realWeek = 3;

        $this->survivor = $this->pool?->contenders->where('user_id', $this->user->id)->first();

        $this->mypicks = $this->survivor->survivorPicks()->get();

        $this->choices = $this->teamsLeft($this->week);

    }

    public function rules()
    {
        return [
            'selectTeam' => [
                'required',
                'integer',
                new BeforeWagerQuestionStart($this->selectTeam),
            ],

            'selectTeamName' => [
                'required',
                'string',
                Rule::unique('survivor', 'selection')->where(function ($query) {
                    return $query->where('ticket_id', $this->survivor->id);
                }),
            ],
            /*
            'result' => [
                'sometimes',
                'boolean',
                new NotTrueOrFalse($this->survivor->survivorPicks->where('week', $this->week)->pluck('result')->implode(',')),
            ],
            */
        ];
    }

    public function messages()
    {
        return [
            'selectTeamName.required' => 'You must select a team.',
            'selectTeamName.unique' => 'You have already used this team: :attribute',
        ];
    }

    public function validationAttributes()
    {
        return [
            'selectTeamName' => $this->selectTeamName,
        ];
    }

    public function updatedSelectTeam($value)
    {
       $this->selectTeamName = WagerOption::where('id', $value)->first()->option;
    }


    public function UpdatedWeek()
    {
        $this->choices = $this->teamsLeft($this->week);
        $this->reset('selectTeam');
    }

    public function teamsLeft($week)
    {
        $picked = $this->mypicks->pluck('selection')->toArray();

        $ScheduleIds = WagerQuestion::where("week", $week)
            ->pluck('game_id')->toArray();

        $Teams = WagerOption::WhereIn('game_id', $ScheduleIds)->get();


        $options = collect();
        foreach ($Teams as $team) {
            //$options->push(collect($team->teaminfo));
            $options->push(collect(['GameID' => $team->game_id, 'OptionID' => $team->id, 'TeamName' => $team->option]));
        }

        $filteredCollection = $options->whereNotIn('TeamName', $picked);
        //$filteredCollection = $options;

        $sortedCollection = $filteredCollection->sortBy('TeamName');

        return $sortedCollection->all();

    }


    public function changeWeek()
    {
        $this->biggestLoser($this->week);
        $this->choices = $this->teamsLeft($this->week);
    }

    public function hydrate()
    {
        $this->biggestLoser($this->week);
        $this->choices = $this->teamsLeft($this->week);

        //$this->mypicks = $this->survivor->survivorPicks()->get();
        //$this->choices = $this->teamsLeft($this->week);
    }


    public function canUpdatePick()
    {
        $fetchPossiblePick = $this->survivor->survivorPicks->where('week', $this->week)->first();
        $status = false;

        if($fetchPossiblePick && is_null($fetchPossiblePick->result)) {
            $status = true;
        } elseif($fetchPossiblePick && !is_null($fetchPossiblePick->result)) {
            return false;
        } else {
            return true;
        }

        //Ensure the previous selection hasnt started (live game)
        if($status) {
            return Carbon::parse(now())->lessThan(Carbon::parse($fetchPossiblePick->question->starts_at));
        }

    }

    public function submit()
    {

        if($this->canUpdatePick()) {

            if ($this->getErrorBag()->isNotEmpty()) {
                $this->error(
                    $this->getErrorBag()->first(),
                    //description: 'what',
                    timeout: 3000,
                    position: 'toast-top toast-end'
                );
            }

            $this->validate();

            $locateSelection = WagerOption::Find($this->selectTeam);

            try {

                // if(is_null($this->survivor->survivorPicks->where('week', $locateSelection->week)->result)) {
                // if($this->canUpdatePick()) {
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
                    title: 'Added! Week ' . $locateSelection->week . ' - ' . $locateSelection->option,
                    description: null,                  // optional (text)
                    position: 'toast-top toast-end',    // optional (daisyUI classes)
                    icon: 'o-information-circle',       // Optional (any icon)
                    css: 'alert-info',                  // Optional (daisyUI classes)
                    timeout: 3000,                      // optional (ms)
                    redirectTo: null                    // optional (uri)
                );
                // }

            } catch (Exception $e) {
                report($e);
                $this->error(
                    'Cannot select ' . $locateSelection->option . '. Check your selections and try again...',
                    timeout: 3000,
                    position: 'toast-top toast-end'
                );
            }

            $this->mypicks = $this->survivor->survivorPicks()->get();
            $this->choices = $this->teamsLeft($this->week);

            $this->reset('selectTeam');

        } else {
            $this->error(
                'Pick locked cannot update',
                timeout: 3000,
                position: 'toast-top toast-end'
            );
        }


    }


    public function isAllowed($pick, $week) {

        $status = true;
         //Locate the game and ensure it hasnt started yet.
            $locateSelection = WagerOption::with('question')
                ->where('week', $week)
                ->where('option', $pick)
                ->first();

            if($locateSelection->ended) {
                $status = false;
                $msg = 'This game is over';
            } else {
                $status = $this->currentTimeEST->lessThan(Carbon::parse($locateSelection->question->starts_at));
                $msg = 'This game is over';
            }

            return [$status, $msg];
    }

    /* Remove pick may need work, but should be ok */
    public function RemovePick(Survivor $id) {

        if($this->canUpdatePick()) {


            $this->authorize('delete', $id);

            if ($id->delete()) {

                $this->choices = $this->teamsLeft($this->week);
                $this->mypicks = $this->survivor->survivorPicks()->get();

                $this->toast(
                    type: 'success',
                    title: $id->selection . ' Removed',
                    description: 'Week: ' . $id->week,                  // optional (text)
                    position: 'toast-top toast-end',    // optional (daisyUI classes)
                    icon: 'o-information-circle',       // Optional (any icon)
                    css: 'alert-info',                  // Optional (daisyUI classes)
                    timeout: 3000,                      // optional (ms)
                    redirectTo: null                    // optional (uri)
                );
            } else {

                $this->error(
                    'Cannot remove' . $id->selection,
                    //description: $isAllowed[1],
                    timeout: 3000,
                    position: 'toast-top toast-end'
                );
            }
        } else {
            $this->error(
                'Cannot remove pick, game is under way',
                timeout: 3000,
                position: 'toast-top toast-end'
            );
        }

    }

    public function biggestLoser($week)
    {

        $lw = $week - 1;

        $biggestLoser = $this->pool->allSurvivors()->Where('week', $lw)->where('result', false)->select('selection')->get();

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
        return view('livewire.survivor-game', [
            'biggestLoser' => $this->biggestLoser($this->week),
            'playerCount' => $this->playerCount(),

        ]);
    }
}
