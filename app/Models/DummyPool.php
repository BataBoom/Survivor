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
        $kilo = Pool::Where('name', 'Kilo')->first();
        $bravo = Pool::Where('name', 'Bravo')->first();
        $pickem = Pool::Where('name', "NBZ Pick'em")->first();

        $ourPromoPools = [
            ['id' => $bravo->id,'name' => 'Bravo', 'type' => 'Survivor', 'guaranteed_prize' => '0.01 BTC', 'entry_cost' => 'FREE', 'total_prize' => '0.01 BTC', 'lives_per_person' => 1, 'model' => $bravo],
            ['id' => $kilo->id,'name' => 'Kilo',  'type' => 'Survivor', 'guaranteed_prize' => '0.005 BTC', 'entry_cost' => '$10.00', 'total_prize' => '0.005 BTC', 'lives_per_person' => 1, 'model' => $kilo],
            ['id' => $pickem->id,'name' => "NBZ Pick'em",  'type' => 'Pickem', 'guaranteed_prize' => '0.0', 'entry_cost' => 'FREE', 'total_prize' => '0.0', 'lives_per_person' => 'N/A' ,'model' => $pickem],
        ];

        return collect($ourPromoPools)->map(function ($item) {
            return new self($item);
        });

    }

    public static function getPromoPoolsForController()
    {

        return Pool::WhereIn('name', ["NBZ Pick'em", 'Kilo', 'Bravo',])->whereNull('creator_id')->orderBy('guaranteed_prize', 'desc')->get();
    }
    

    public static function setupPromoPools()
    {

        $ourPromoPools = [
            ['id' => null, 'name' => 'Bravo', 'type' => 'survivor', 'guaranteed_prize' => '600.00', 'entry_cost' => '0.00', 'lives_per_person' => 1, 'prize_type' => 'crypto', 'status' => 1],
            ['id' => null,'name' => 'Kilo',  'type' => 'survivor', 'guaranteed_prize' => '300.00', 'entry_cost' => '10.00', 'lives_per_person' => 1, 'prize_type' => 'crypto', 'status' => 1],
            ['id' => null,'name' => "NBZ Pick'em",  'type' => 'pickem', 'guaranteed_prize' => '0', 'entry_cost' => '0.00', 'lives_per_person' => 1000, 'prize_type' => 'crypto', 'status' => 1],
        ];

        return $ourPromoPools;

    }
}
