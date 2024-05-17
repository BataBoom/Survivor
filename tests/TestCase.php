<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use App\Models\WagerResult;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {

        parent::setUp();

        $alreadySeeded = WagerResult::All()->isEmpty();

        if ($alreadySeeded) {
            $this->artisan('db:seed', ['--class' => 'TestDatabaseSeeder']);
        }
    }
}
