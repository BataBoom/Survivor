<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pool;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(['name' => 'admin', 'email' =>  'admin@github.com', 'password' =>  Hash::make(config('survivor.admin_pw')), 'email_verified_at' => now()]);

        /* Currently Admin bypasses all Policy's. This should get fixed,
        *  But in the meantime for first time installers this is likely the way to go. */

        foreach(Pool::All() as $pool) {
            $pool->registration()->create([
                'user_id' => 1,
                'alive' => true,
                'lives_count' => $pool->lives_per_person,
            ]);
        }
    }
}
