<?php

namespace App\Models;

use Illuminate\Support\Collection;
use App\Models\Pool;

class DummyPool
{
    public $attributes;

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function __get($key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function pool()
    {
        return $this->attributes['model'];
    }

    /* Custom pools for Admins/Site Promotional Pools, so it doesn't trigger payment stuff */
    public static function getPromoPools()
    {
        $kilo = Pool::Find("9c35cc31-231c-43f6-aa51-d86d17512e1e");
        $bravo = Pool::Find("9c35cbef-a356-40fe-931c-21bfc18733d6");
        $pickem = Pool::Find("9c35c839-713e-4ad2-9d38-585f56a9d521");

        $ourPromoPools = [
            ['id' => $bravo->id,'name' => 'Bravo', 'type' => 'Survivor', 'guaranteed_prize' => '0.01 BTC', 'entry_cost' => 'FREE', 'total_prize' => '0.01 BTC', 'lives_per_person' => 1, 'model' => $bravo],
            ['id' => $kilo->id,'name' => 'Kilo',  'type' => 'Survivor', 'guaranteed_prize' => '0.005 BTC', 'entry_cost' => '$10.00', 'total_prize' => '0.005 BTC', 'lives_per_person' => 1, 'model' => $kilo],
            ['id' => $pickem->id,'name' => 'NBZ Pickem',  'type' => 'Pickem', 'guaranteed_prize' => '0.0', 'entry_cost' => 'FREE', 'total_prize' => '0.0', 'lives_per_person' => 'N/A' ,'model' => $pickem],
        ];

        return collect($ourPromoPools)->map(function ($item) {
            return new self($item);
        });

    }
}
