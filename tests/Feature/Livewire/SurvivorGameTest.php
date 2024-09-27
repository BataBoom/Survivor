<?php

namespace Tests\Feature\Livewire;

use App\Models\Pool;
use App\Models\SurvivorRegistration;
use App\Models\User;
use App\Rules\BeforeWagerQuestionStart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use App\Livewire\SurvivorGame;
use App\Models\WagerQuestion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Livewire\Traits\SurvivorTrait;

class SurvivorGameTest extends TestCase
{
    use RefreshDatabase, SurvivorTrait;

    public $pool;

    public $user;

    public $ticket;

    public $week = 4; //Not allowing me to set custom week, not going to bother, but this does slow down testing time cause sys has to import all X weeks of games from API.

    protected function setUp(): void
    {
        parent::setUp();

        //Fetch pool
        $this->pool = Pool::Factory()->survivor()->create();

        $this->user = $this->pool->users->random();

        $this->ticket = SurvivorRegistration::Where('pool_id', $this->pool->id)->where('user_id', $this->user->id)->first();

    }

    /** @test */
    public function test_renders_successfully()
    {
        //$ticket = SurvivorRegistration::Where('pool_id', $this->pool->id)->where('user_id', $this->user->id)->first();
        Livewire::actingAs($this->user)
        ->test(SurvivorGame::class, ['pool' => $this->pool])
        ->assertStatus(200)
        ->assertSetStrict('week', $this->decipherWeek())
        ->assertSetStrict('realWeek', $this->decipherWeek());
        //->assertSetStrict('survivor', $ticket);
    }

    public function test_submit_pick()
    {

        $randomWager = WagerQuestion::withWhereHas('gameoptions')
            ->where('week', $this->decipherWeek())
            ->inRandomOrder()
            ->first();

            

        $randomSelection = $randomWager->gameoptions->first();

        log::debug($randomSelection->option);

        Livewire::actingAs($this->user)
            ->test(SurvivorGame::class, ['pool' => $this->pool])
            ->assertStatus(200)
            ->assertSetStrict('week', $this->decipherWeek())
            ->assertSetStrict('realWeek', $this->decipherWeek())
            ->assertSee('currentTimeEST', Carbon::now())
            ->set('selectTeam', $randomSelection->id)
            //->set('selectTeam', $randomSelection->team_id)
            ->set('selectTeamName', $randomSelection->option)
            //cant figure out how to test Rule Class BeforeWagerQuestionStart, but passing validation rules here seems fine..
            ->assertHasNoErrors(['selectTeam' => ['required', 'integer']])
            ->assertHasNoErrors('selectTeamName')
            ->call('submit')
            ->assertDontSeeHtml('<option class="text-white text-xl" value="28">\n'.$randomSelection->option.'\n</option>\n')
            ->assertDontSeeHtml('<li class="row mb-2 text-center">No selections made, select a team for week 1</li>');

            $this->assertNotEmpty([$this->ticket->survivorPicks]);

            //log::info($this->ticket->survivorPicks);

    }


}
