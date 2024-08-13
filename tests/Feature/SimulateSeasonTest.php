<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Traits\RefreshSpecificTable;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use App\Models\Survivor;
use App\Models\Pool;
use App\Models\SurvivorRegistration;
use App\Models\User;
use App\Models\WagerQuestion;
use App\Events\SurvivorGradedEvent;
use Illuminate\Support\Facades\Log;

class SimulateSeasonTest extends TestCase
{
    use RefreshDatabase;

    public $pool;

    public $maxWeeks = 2;


    protected function setUp(): void
    {
        parent::setUp();
        //$this->artisan('db:seed', ['--class' => 'TestScheduleSeeder']);

        //Fetch pool
        $this->pool = Pool::Factory()->survivor()->create();

        //Fetch simulated pool
        //$this->pool = $this->pool->load('survivors');

        //set games to simulate
        config(['seeder.games' => $this->maxWeeks]);

        //setup Simulation | Move away from Seeder class for Simulate and run it in a test as it should be!
        //$this->artisan('db:seed', ['--class' => 'SimulateSeasonSeeder']);

        $contenders = $this->pool->contenders;
        foreach ($contenders as $contender) {
            for($i = 1; $i <= $this->maxWeeks; $i++) {
                $contender->picks()->save(Survivor::Factory([
                  'user_id' => $contender->user_id,
                  'ticket_id' => $contender->id,
                ])->week($i)->create());
            }
        }       

    }


    //2 is fetched from Pool Factory
    public function test_pool_has_numbers(): void
    {
        $wagerCount = $this->maxWeeks * $this->pool->contenders->count();

        //Count users in Pool
        $this->assertEquals(2, $this->pool->contenders->count());

        //Count Wagers in Pool
        $this->assertEquals($wagerCount, $this->pool->survivors->count());

    }

    public function test_grade_survivor_event(): void
    {
        Event::fake();

        for($i = 1; $i <= $this->maxWeeks; $i++) {
           $this->artisan('grade:survivor', ['week' => $i]);
        }

        Event::assertDispatched(SurvivorGradedEvent::class, $this->pool->contenders->count() * $this->maxWeeks);
    }

}
