<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\WagerTeam;
use App\Models\WagerOption;
use App\Models\WagerQuestion;
use App\Models\WagerResult;
use App\Models\Pool;
use App\Models\Survivor;
use App\Models\User;
use App\Models\SurvivorRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SurvivorTest extends TestCase
{
    //use RefreshDatabase;

    public $pool;
    public $week;
    public $user;
    public $game;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::Factory()->create();
        $this->pool = Pool::Factory()->single()->create();
        $this->game = Survivor::Factory(['user_id' => $this->user->id, 'pool_id' => $this->pool->id])->create();
    }


    public function test_single_survivor_result(): void
    {

        info([$this->game, $this->game->results]);

        $this->assertInstanceOf(WagerResult::class, $this->game->results);
        $this->assertInstanceOf(Survivor::class, $this->game);

        $this->game->update(['result' => $this->game->selection_id === $this->game->results->winner]);

    }

    public function test_multiple_survivor_result(): void
    {

        info(WagerResult::All()->take(3));

        $this->assertTrue(true);
    }
}
