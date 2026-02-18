<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

return [
    'start_date' => Carbon::createFromDate(2025, 9, 8, 'UTC'),
    'over_date' => Carbon::createFromDate(2026, 1, 5, 'UTC'),
    'payments' => true,
    'admin_pw' => env('ADMIN_PW'),
    'dummy_pools' => false,
    'init' => [
        'create_pickem_when_admin_registers' => true,
        'add_future_users_to_first_pickem_pool' => true,
    ],

];
