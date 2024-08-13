<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DummyPool;
use App\Models\Pool;

class CreateDummyPools extends Seeder
{
    /**
     * Create Optional Promotional Pools
     */
    public function run(): void
    {

        $dummyPools = DummyPool::setupPromoPools();

        foreach($dummyPools as $dummy) {
            Pool::Create($dummy);
        }
    }
}
