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
use DateTime;


class SurvivorGame extends Component
{
    public $mypool = "9c10208a-2840-4a75-9872-b59f491610f3";
    public $week;
    public $choice = '';
    public $pickteam;
    public $delteam;
    public $newweek;
    public $gameid;
    public $currentPool;
    public $bl;
    public $status;
    public User $user;
    public $selectedweek;
    public $showComments = false;

    public $rules = [
        'pickteam' => 'required|array',
        'delteam' => 'required|array',
    ];

    public function mount()
    {

        //$this->newweek = $this->decipherWeek()
        $this->user = Auth::user();
        $this->week = $this->newweek ?? $this->decipherWeek();
        $this->status = $this->status();
        $this->currentPool = Pool::Find($this->mypool);

    }

    public function changeWeek()
    {
        $this->week = $this->newweek ?? $this->decipherWeek();
    }

    public function status()
    {
        //return $this->user->pools()->where('pool_id', $this->mypool)->where('alive',1)->exists() ? true : false;
        return true;
    }


    public function hydrate() {
        $this->reset('week');
        $this->lastPick();
        $this->changeWeek();
        $this->teamsLeft($this->week);
        $this->allGames($this->week);
        $this->biggestLoser($this->week);
    }

    public function isAllowed($pick) {

        $this->selectedweek = $this->newweek ?? $this->decipherWeek();

        //Determine if user has placed this pick before, and if he has it hasnt been graded yet.
        $status = false;
        if($this->user->mySurvivorPicks()->where('selection', $pick)->where('pool', $this->mypool)->whereNotNull('result')->doesntExist()) {
            $status = true;

            // Retrieve schedule for the selected week
            $Schedule = WagerQuestion::Where("week", $this->selectedweek)->get();
            $gameIDz = [];
            foreach ($Schedule as $onegame) {
                $options = WagerOption::where('game_id', $onegame->game_id)->pluck('game_id')->flatten();
                $gameIDz = array_unique(array_merge($gameIDz, $options->all()));
            }

            // Find the location of the picked team
            $locate = WagerOption::whereIn('game_id', $gameIDz)->where('option', $pick)->get();

            //Determine is the game has already started
            $nowEastern = Carbon::now('EST');
            $isLive = $nowEastern->lessThan($locate->first()->question->starts_at);

        } else {
            $status = false;
            $message = "You've already used this team, and the match has been graded.";
        }

        //if user is allowed instantly return true, otherwise return with message;
        if($status && $isLive) {
            $status = true;
        } else {
            $message = "Match started, cannot update pick!";
            $status = false;
        }

        return [$status, $message ?? ""];

    }


    public function RemovePick() {

        $this->validateOnly('delteam');

        //dd($this->delteam);
        $isAllowed = $this->isAllowed($this->delteam[0]);
        $status = false;
        if($isAllowed[0] && $this->status()) {

            $delete = $this->user->mySurvivorPicks()->where('selection', $this->delteam[0])->where('pool', $this->mypool)->delete();
            $status = true;

        }

        if($status) {
            //emit?
        } else {
            dd($isAllowed[1]);
        }

    }

    public function submit()
    {

        $this->validateOnly('pickteam');

        $isAllowed = $this->isAllowed($this->pickteam[0]);
        $status = false;
        if($isAllowed[0] && $this->status()) {
            $status = true;
            $this->selectedweek = $this->newweek ?? $this->decipherWeek();

            // Retrieve schedule for the selected week
            $Schedule = WagerQuestion::Where("week", $this->selectedweek)->get();
            $gameIDz = [];
            foreach ($Schedule as $onegame) {
                $options = WagerOption::where('game_id', $onegame->game_id)->pluck('game_id')->flatten();
                $gameIDz = array_unique(array_merge($gameIDz, $options->all()));
            }

            // Find the location of the picked team
            $locate = WagerOption::whereIn('game_id', $gameIDz)->where('option', $this->pickteam[0])->get();

            try {
                Survivor::updateOrCreate(
                    ['week' => $this->selectedweek, 'uid' => $this->user->id, 'pool' => $this->mypool],
                    [
                        'game_id' => $locate->first()->game_id,
                        'selection_id' => $locate->first()->team_id,
                        'selection' => $locate->first()->option,
                        'pool' => $this->mypool,
                    ]
                );
                $iffy = true;
            } catch (Exception $e) {
                $iffy = false;
            }

            if($status !== false && $iffy) {
                session()->flash('successmsg', 'Added! Week ' . $this->selectedweek.' - '.$this->pickteam[0]);
            } else {
                session()->flash('errormsg', 'Cannot select ' . $this->pickteam[0]. '. Check your selections and try again. You can delete selections if you open this in a new tab (top right).');
            }
        }

    }

    public function getAbbreviations($week)
    {
        $ScheduleIds = WagerQuestion::where('week', $week)->pluck('game_id')->toArray();
        $Games = WagerQuestion::WhereIn('game_id', $ScheduleIds)->get();

        $options = collect();
        foreach ($Games as $game) {
            $teamIds = $game->gameoptions()->pluck('team_id');
            $teamAbbreviations = WagerTeam::whereIn('team_id', $teamIds)->pluck('abbreviation');

            $options->push($teamAbbreviations);
        }

        return $options;
    }

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

    public function getGames($week)
    {
        return WagerQuestion::all()->where('week', $week);
    }

    public function picked()
    {
        $pickedTeams = $this->user->SurvivorPicks()->where('pool_id', $this->mypool)->pluck('selection_id')->toArray();
        $picked = WagerTeam::whereIn('team_id', $pickedTeams)->get();

        return $picked;
    }

    public function teamsLeft($week)
    {
        $currentDatetime = Carbon::now();
        $picked = $this->user->SurvivorPicks->where('pool_id', "9c10208a-2840-4a75-9872-b59f491610f3")->whereNotNull('result')->pluck('selection_id')->toArray();
        $ScheduleIds = WagerQuestion::where("week", $week)
            ->where('starts_at', '>', $currentDatetime->toDateTimeString())
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
    /*
        public function teams($week)
        {

        $ScheduleIds = WagerQuestion::where('week', $week)->pluck('game_id')->toArray();
        $Teams = WagerOption::WhereIn('game_id', $ScheduleIds)->get();

        $options = collect();
        foreach ($Teams as $team) {
        $options->push(collect($team->teaminfo));
        }

        return $options;


        }
    */
    public function weeklyPicks()
    {

        $picked = $this->user->SurvivorPicks->where('pool_id', $this->mypool);
        if ($picked->count() > 0) {
            return $picked;
        } else {
            return [];
        }

    }

    public function lastPick()
    {

        $last = Survivor::getLastPickByUser(Auth::user(), $this->mypool);
        if($last) {
            return array($last->week => $last->selection);
        } else {
            return [];
        }


    }

    public function deleteablePicks() {

        return $this->user->SurvivorPicks->where('pool_id', $this->mypool)->whereNull('result');
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

    public function biggestLoser($week)
    {

        $lw = $week - 1;

        /*
        $Schedule = WagerQuestion::all()->where('week', $lw);

        $biggestLoser = Survivor::Where('week', $lw)->where('result', false)->where('pool', $this->mypool)->select('selection')->get();
        $count = $biggestLoser->count();
        if($count >= 1) {
        $biggestLoser->first()->selection;
        $bl = [$count => $biggestLoser->first()->selection];
        } else {
        $bl = null;
        }

        return $bl;
        */

        $biggestLoser = Survivor::Where('week', $lw)->where('result', false)->where('pool_id', $this->mypool)->select('selection')->get();

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

    public function playerCount() {

        $playerCount = ['Alive'=> SurvivorRegistration::Where('alive', 1)->where('pool_id', $this->mypool)->count(), 'Dead' => SurvivorRegistration::Where('alive', 0)->where('pool_id', $this->mypool)->count()];

        return $playerCount;
    }



    public function render()
    {
        //dd($this->playerCount());
        //dd($this->currentPool);

        /*
        $players = $this->playerCount();
        if($players['Alive'] === 1) {
        return view('livewire.survivor_won');
        }
        */

        return view('livewire.survivor-game', [
            'allGames' => $this->allGames($this->week),
            'games' => $this->getGames($this->week),
            //'teams' => $this->teams($this->week),
            'choices' => $this->teamsLeft($this->week),
            'picked' => $this->picked(),
            'mypicks' => $this->weeklyPicks(),
            'latestpick' => $this->lastPick(),
            'whatweek' => $this->decipherWeek(),
            'week' => $this->changeWeek(),
            'biggestLoser' => $this->biggestLoser($this->week),
            'status' => $this->status,
            'delPicks' => $this->deleteablePicks(),
            'playerCount' => $this->playerCount(),

        ]);
    }
}
