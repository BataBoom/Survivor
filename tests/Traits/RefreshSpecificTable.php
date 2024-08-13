<?php

namespace Tests\Traits;

use Illuminate\Support\Facades\DB;

trait RefreshSpecificTable
{
    /**
     * Truncate and reseed the specified table.
     *
     * @param string $table
     * @return void
     */
    public function refreshTable($table)
    {
        DB::table($table)->delete();
        //$this->artisan('db:seed', ['--class' => ucfirst($table) . 'TableSeeder']);
    }
}
