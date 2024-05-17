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
    use RefreshDatabase;

    public $pool;
    public $week;
    public $user;
    public $game;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::Factory()->create();
        $this->pool = Pool::Factory()->create();
        $this->game = Survivor::Factory(['user_id' => $this->user->id, 'pool_id' => $this->pool->id])->create();
    }
    /**
     * A basic unit test example.
     */
    public function test_wager_results(): void
    {


        $winner = $this->game->question->gameoptions->random();

        if ($winner->home_team) {
            $scores = ['home' => rand(21, 48), 'away' => rand(7, 20)];
        } else {
            $scores = ['away' => rand(21, 48), 'home' => rand(7, 20)];
        }

        $gg = WagerResult::Create([
            'game' => $this->game->question->game_id,
            'winner' => $winner->team_id,
            'winner_name' => $winner->option,
            'week' => $winner->week,
            'home_score' => $scores['home'],
            'away_score' => $scores['away'],
        ]);

        info($gg);

        $this->assertTrue(true);
    }
}
