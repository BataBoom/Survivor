<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Survivor;
use App\Models\Pool;
use App\Models\SurvivorRegistration;
use App\Models\User;
use App\Models\WagerQuestion;

class SimulateSeasonTest extends TestCase
{
    //use RefreshDatabase;

    public $pool;
    protected function setUp(): void
    {
        parent::setUp();
        $this->pool = Pool::Latest()->first()->load('survivors');
    }


    public function test_pool_has_numbers(): void
    {

        //Count users in Pool
        $this->assertEquals(2, $this->pool->contenders->count());

        //Count Wagers in Pool
        $this->assertEquals(22, $this->pool->survivors->count());


    }

    public function test_pool_winner(): void
    {

        //Count users in Pool
        $this->assertEquals(2, $this->pool->contenders->count());

        //Count Wagers in Pool
        $this->assertEquals(22, $this->pool->survivors->count());


    }

}
