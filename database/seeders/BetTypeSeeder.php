<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\BetType;

class BetTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

         $betTypes = [
            ['value' => 'Moneyline'],
            ['value' => 'First Half ML'],
            ['value' => 'Second Half ML'],
            ['value' => 'Spread'],
            ['value' => 'Totals'],
            ['value' => 'Prop'],
            ['value' => 'Parlay'],
            ['value' => 'Teaser'],
        ];

        BetType::insert($betTypes);
    }
}
