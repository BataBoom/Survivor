<?php

namespace App\Http\Controllers;

use App\Models\Pool;
use App\Models\User;
use App\Models\WagerOption;
use App\Models\WagerQuestion;
use App\Models\WagerTeam;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;


class PickemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showByPool(Request $request, Pool $pool)
    {
        $pickem = Pool::Where('type', 'pickem')->first();

        return view('pickem.index', [
            'pool' => $pool,
            'survivor' => Auth::user()
                ->survivorPools
                ->where('pool_id', $pool->id)
                ->first(),
            'mySurvivorPools' => Auth::user()->survivorPools->load('pool'),
            'globalPickem' => $pickem,
        ]);
    }

    public function viewStats(Request $request, Pool $pool)
    {
        return view('pickem.stats', [
            'pool' => $pool,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Pool $pool)
    {

        $games = WagerQuestion::Where('week', 1)->get();
        $combinedData = collect();
        foreach ($games as $game) {
            $teamIds = $game->gameoptions()->pluck('team_id');
            $teamInfo = WagerTeam::whereIn('team_id', $teamIds)->select('abbreviation', 'name', 'team_id', 'color', 'altColor')->get();

            $item = (object)[
                'game' => $game->question,
                'starts' => $game->starts_at,
                'gid' => $game->game_id,
                'mid' => $game->id,
                'info' => $teamInfo,
            ];

            $combinedData->push($item);
        }

        return view('pickem.show', [
            'pool' => $pool,
            'ticket' => Auth::user()
                ->pickemPools
                ->where('pool_id', $pool->id)
                ->first(),
            'games'=> $combinedData,
            'myPickemPools' => Auth::user()->pickemPools->load('pool'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
