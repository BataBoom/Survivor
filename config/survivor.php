<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

return [
    'start_date' => Carbon::createFromDate(2024, 9, 5, 'America/New_York'),
    'over_date' => Carbon::createFromDate(2025, 1, 15, 'America/New_York'),
    'admin_pw' => env('ADMIN_PW'),
    'init' => [
        'create_pickem_when_admin_registers' => true,
        'add_future_users_to_first_pickem_pool' => true,
    ],

];