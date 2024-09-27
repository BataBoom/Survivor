<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCaseSeeders;

class BetSlipSeederTest extends TestCaseSeeders
{
    use RefreshDatabase; 

    /**
     * Test if the database seeders run without errors.
     *
     * @return void
     */
    public function test_sports_seeder_run_without_errors()
    {
        
        $this->artisan('db:seed --class="SportSeeder"')
             ->assertExitCode(0);

        $this->assertDatabaseCount('sports', 8); 


        $this->assertDatabaseHas('sports', ['name' => 'American Football']);
    }

    /**
     * Test if the database seeders run without errors.
     *
     * @return void
     */
    public function test_betslip_seeders_run_without_errors()
    {
       
        $this->artisan('db:seed --class="TestDatabaseSeeder"')->assertExitCode(0);
        /*
        $this->artisan('db:seed --class="SportSeeder"')->assertExitCode(0);

        $this->artisan('db:seed --class="LeagueSeeder"')->assertExitCode(0);

        $this->artisan('db:seed --class="WagerTeamsSeeder"')->assertExitCode(0);
        */

    }
}
