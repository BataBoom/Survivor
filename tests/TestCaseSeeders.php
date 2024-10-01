<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use App\Models\WagerResult;

abstract class TestCaseSeeders extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {

        parent::setUp();

    }
}