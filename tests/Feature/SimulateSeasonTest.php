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

class SimulateSeasonTest extends TestCase
{
    //use RefreshDatabase;
    use RefreshSpecificTable;

    public $pool;

    public $maxWeeks = 2;
    protected function setUp(): void
    {
        parent::setUp();
        //$this->artisan('db:seed', ['--class' => 'TestScheduleSeeder']);

        //refresh
        $this->refreshTable('survivor_pools');

        //set games to simulate
        config(['seeder.games' => $this->maxWeeks]);

        //setup Simulation
        $this->artisan('db:seed', ['--class' => 'SimulateSeasonSeeder']);

        //Fetch simulated pool
        $this->pool = Pool::Latest()->first()->load('survivors');

    }


    //10 is fetched from Factory, so has to be static num
    public function test_pool_has_numbers(): void
    {
        $wagerCount = $this->maxWeeks * $this->pool->contenders->count();

        //Count users in Pool
        $this->assertEquals(10, $this->pool->contenders->count());

        //Count Wagers in Pool
        $this->assertEquals($wagerCount, $this->pool->survivors->count());


    }

    public function test_grade_selections(): void
    {
        //Count users in Pool
        $this->assertEquals(10, $this->pool->contenders->count());

        //Count Wagers in Pool
         $this->assertEquals(10 * $this->maxWeeks, $this->pool->survivors->count());
    }

    public function test_grade_survivor(): void
    {
        Event::fake();

        for($i = 1; $i <= $this->maxWeeks; $i++) {
           $this->artisan('grade:survivor', ['week' => $i]);
        }

        Event::assertDispatched(SurvivorGradedEvent::class, $this->pool->users->count() * $this->maxWeeks);

        $remainingSurvivors = $this->pool->contenders->count();
        $this->assertEquals($this->pool->contenders->count(), $remainingSurvivors);

    }
}
