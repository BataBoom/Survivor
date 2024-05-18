<?php

namespace Tests\Feature\Livewire;

use App\Livewire\SurvivorGame;
use App\Models\SurvivorRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use App\Models\User;
use App\Models\Pool;

class SurvivorGameTest extends TestCase
{
    //use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function renders_successfully()
    {
        $user = User::Factory()->create();
        $pool = Pool::Factory()->single()->create();
        $registration = SurvivorRegistration::Factory(['user_id' => $user->id, 'pool_id' => $pool->id])->create();

        Livewire::actingAs($user)
        ->test(SurvivorGame::class, ['mypool' => $pool->id])
        ->assertStatus(200)
        ->assertNotSetStrict('currentPool', $pool)
        ->assertSetStrict('status', true)
        ->assertSet('week', 1)
        ->assertSet('mypool', $pool->id)
    }
}
