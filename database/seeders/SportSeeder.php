<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sport;

class SportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sports = [
            ['name' => 'American Football'],
            ['name' => 'World Football'],
            ['name' => 'Baseball'],
            ['name' => 'Ice Hockey'],
            ['name' => 'Basketball'],
            ['name' => 'Boxing'],
            ['name' => 'Mixed Martial Arts'],
            ['name' => 'Other'],
        ];

        Sport::insert($sports);
    }
}
