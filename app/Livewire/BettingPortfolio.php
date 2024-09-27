<?php

namespace App\Livewire;

use Livewire\Component;
use App\Http\Services\BettingOdds;
use DateTime;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use DateTimeZone;
use Illuminate\Support\Collection;
use App\Models\WagerQuestion;
use App\Models\BetSlip;
use App\Models\WagerOption;
use App\Models\WagerTeam;
use App\Models\BetType;
use App\Models\League;
use Livewire\Attributes\Validate;
use Illuminate\Validation\Rule;
use Mary\Traits\Toast;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Traits\SurvivorTrait;

class BettingPortfolio extends Component
{
    use Toast, SurvivorTrait;

    public int $odds = -100;

    public int $betAmount = 100;

    public $eventStart;

    private $bettingSrvc;

    public $potentialProfit;

    public $TZ;

    public array $timezones;

    public array $sports;

    public Collection $nflGames;

    public Collection $betOptions;

    public array $betTypes;

    public string $selectedSport = 'NFL';

    public $selectedBetType;

    public $selectedGame;

    public $selectedGameID;

    public $selectedOutcome;

    public $selectedOutcomeID;

    public $eventOption;

    public $eventName;

    public $notes;

    public int $selectedWeek;

    public int $userID;

    public bool $selectResult = false;

    public $hasResult;

    

    public function mount()
    {
        $this->selectedWeek = $this->decipherWeek();
        $this->timezones = $this->fetchTimezones();
        $this->sports = $this->fetchSports();
        $this->nflGames = $this->fetchNFLGames($this->selectedWeek);
        $this->betOptions = $this->fetchWagerTeams();
        $this->betTypes = $this->fetchBetTypes();
        $this->userID = Auth::user()->id;


        if($this->selectedSport == 'NFL') {
            $this->nflGames = $this->fetchNFLGames($this->selectedWeek);
            //$this->selectedGame = $this->nflGames->first();
            //$this->eventStart = $this->selectedGame->starts_at->setTimezone($this->TZ)->toDateTimeString();
        }



        $this->bettingSrvc = new BettingOdds;
    }

    public function rules()
    {

        if($this->selectedSport === 'NFL') {

            return [
            'userID' => 'required|exists:users,id',
            'selectedSport' => 'required|string',
            'selectedGameID' => 'sometimes|required|exists:wager_questions,id',
            'selectedOutcomeID' => 'sometimes|required|exists:wager_teams,id',
            'selectedBetType' => 'nullable|exists:bet_types,id',
            //'eventName' => 'sometimes|nullable|string',
            //'eventOption' => 'sometimes|nullable|string',
            'odds' => 'required|integer',
            'betAmount' => 'required|integer',
            'eventStart' => 'required|date',
            'notes' => 'nullable|string',
            'hasResult' => 'nullable|integer',
            ];

        } else {

            return [
            'userID' => 'required|exists:users,id',
            'selectedSport' => 'required|string',
            'eventName' => 'sometimes|required|string',
            'eventOption' => 'sometimes|nullable|string',
            'selectedOutcomeID' => 'sometimes|required|exists:wager_teams,id',
            'selectedBetType' => 'nullable|exists:bet_types,id',
            'odds' => 'required|integer',
            'betAmount' => 'required|integer',
            'eventStart' => 'required|date',
            'notes' => 'nullable|string',
            'hasResult' => 'nullable|integer',

            ];
        }
        
    }


    public function messages() 
    {
        return [
            'selectedSport.required' => 'The :attribute are missing.',
            'selectedGameID.required' => 'The :attribute are missing.',
            'selectedOutcomeID.required' => 'The :attribute are missing.',
            'eventName.required' => 'The :attribute are missing.',
            'eventOption.required' => 'The :attribute are missing.',
            //'eventOutcomeID.required' => 'The :attribute are missing.',
            'odds.required' => 'The :attribute are missing.',
            'betAmount.required' => 'The :attribute are missing.',
            'eventStart.required' => 'The :attribute are missing.',
            'hasResult.required' => 'The :attribute are missing.',

        ];
    }

    public function validationAttributes() 
    {
        return [
            'selectedSport' => 'sport',
            'selectedGameID' => 'game',
            'selectedSport' => 'sport',
            'eventOption' => 'option',
            'eventName' => 'event',
            'odds' => 'odds',
            'betAmount' => 'betAmount',
            'hasResult' => 'show result?',
            'selectedBetType' => 'bet type',
            //'eventOutcomeID' => 'eventOutcomeID',
        ];
    }

    public function fetchWagerTeams(): Collection
    {
        return WagerTeam::Where('league', strtolower($this->selectedSport))->get();
        //return WagerTeam::Where('league_id', strtolower($this->selectedSport))->get();
        //return WagerTeam::All();
    }

    public function fetchTimezones(): array
    {
            $ustz = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, "US");
            $catz = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, "CA");
            $uktz = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, "GB");
            $kotz = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, "KR");
            $guam = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, "GU");
            $de = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, "DE");
            $all = array_merge($ustz, $catz, $uktz, $kotz, $guam, $de);
            return $all;
    }

    public function fetchSports(): array
    {
        return [
            'NFL',
            'NHL',
            'NBA',
            'MLB',
            'NCAAF',
        ];
    }

    public function fetchBetTypes(): array
    {
        return BetType::All()->map(function ($item) {
            return [
                "id" => $item["id"],
                "name" => $item["value"],
            ];
        })->toArray();
    }

    public function fetchNFLGames($week): Collection
    {
        return WagerQuestion::Where('week', $week)->get();
    }

    public function setTimezone($tz): void
    {
        $this->TZ = $tz ?? 'America\New_York';

        $allTZ = $this->fetchTimezones();

        $allTZ[0] = $this->TZ;

        $this->timezones = $allTZ;
    }

    public function updatedSelectedWeek()
    {

        if($this->selectedSport == 'NFL') {
            $this->nflGames = $this->fetchNFLGames($this->selectedWeek);
            //$this->selectedGame = $this->nflGames->first();
            //$this->eventStart = $this->selectedGame->starts_at->setTimezone($this->TZ)->toDateTimeString();
        }
        
    }

    public function updatedSelectedGameID()
    {   
        if($this->selectedSport === 'NFL') {
            $this->selectedGame = WagerQuestion::Find($this->selectedGameID);

            $this->eventStart = $this->selectedGame->starts_at->setTimezone($this->TZ)->toDateTimeString();
        } else {


            $this->eventStart = Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i'), $this->TZ)
              ->setTimezone('UTC')
              ->toDateTimeString();
        }

        //dd($this->selectedGame);
    }

    public function updatedSelectedOutcomeID()
    {

        //dd($this->selectedOutcomeID);
        $this->selectedOutcome = WagerOption::Find($this->selectedOutcomeID);
    }

    public function updatedSelectedSport()
    {

        if($this->selectedSport !== 'NFL') {
           // $this->reset('TZ');
        }

        $this->betOptions = $this->fetchWagerTeams();

    }

    public function updatedTZ()
    {

        if($this->selectedSport === 'NFL') {
           $this->eventStart = $this->selectedGame->starts_at->setTimezone($this->TZ)->toDateTimeString();
        } else {
            /*
            $this->eventStart = Carbon::createFromFormat('Y-m-d H:i', $this->eventStart, $this->TZ)
              ->setTimezone('UTC')
              ->toDateTimeString();
              */
        }

    }

    public function updatedOdds()
    {
        //return $this->bettingSrvc->odds = $this->odds; 
    }

    public function updatedBetAmount()
    {
        //dd($this->betAmount ?? 'UNSET');
        //$this->bettingSrvc->bettingAmount = $this->betAmount;
    }

    public function save()
    {  

        $this->validate();
        //dd($this->getErrorBag());
        $this->bettingSrvc = new BettingOdds;
        $this->bettingSrvc->bettingAmount = $this->betAmount;
        $this->bettingSrvc->odds = $this->odds;
        

        if(isset($this->bettingSrvc->odds) && isset($this->bettingSrvc->bettingAmount))
        {
            $this->potentialProfit = $this->bettingSrvc->toPayout();
            //return $this->potentialProfit;
        }
        
  
       $leagueID = League::Where('name', strtoupper($this->selectedSport))->first()?->id;

       $create = BetSlip::Create([
            'user_id' => $this->userID,
            'sport' => $this->selectedSport,
            'league_id' => $leagueID,
            'game_id' => $this->selectedGame?->game_id,
            'selection_id' => $this->selectedOutcomeID,
            'unscheduled_option' => $this->eventOption ?? null,
            'unscheduled_event' => $this->eventName ?? null,
            'odds' => $this->odds,
            'bet_amount' => $this->betAmount,
            'bet_type' => $this->selectedBetType,
            'starts_at' => $this->eventStart,
            'notes' => $this->notes,
            'result' => $this->hasResult,
        ]);

        if($create->id) {

            $this->success(
                'Created Betslip!',
                timeout: 3000,
                position: 'toast-top toast-center'
            );

            $this->reset('selectedGameID');
            $this->reset('selectedGame');
            $this->reset('selectedOutcomeID');
            $this->reset('selectedOutcome');
            $this->reset('eventOption');
            $this->reset('eventName');
            //$this->reset('eventStart');
            $this->reset('notes');
            $this->reset('hasResult');
            //$this->reset('eventOutcomeID');

        } else {
            $this->error(
                'Cannot create betslip',
                timeout: 3000,
                position: 'toast-top toast-center'
            );
        }
        
    
    }

    public function render()
    {
        return view('livewire.betting-portfolio')
        ->layout('components.layouts.survivor');
    }
}
