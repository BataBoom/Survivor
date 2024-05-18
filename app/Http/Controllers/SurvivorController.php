<?php

namespace app\Http\Controllers;

use App\Events\ModifySurvivorEvent;
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

class SurvivorController extends Controller
{
    public function fun()
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

        return view('fun', ['games'=> $combinedData]);
    }

    public function home()
    {   
    
    $week = 1;
    $ScheduleIds = WagerQuestion::where('week', $week)->pluck('gameid')->toArray();
    $Teams = WagerOption::WhereIn('game_id', $ScheduleIds)->get();
    $Games = WagerQuestion::WhereIn('gameid', $ScheduleIds)->get();
    
    $options = collect();
    foreach ($Games as $game) {
    $teamIds = $game->gameoptions()->pluck('teamid');
    $teamInfo = WagerTeam::whereIn('team_id', $teamIds)->select('abbreviation', 'name','team_id')->get();

    $combinedData = collect([
        'game' => $game->question,
        'starts' => $game->starts_at,
        'gid' => $game->gameid,
        'mid' => $game->id,
        'info' => $teamInfo,

    ]);
    $options->push($combinedData);
    }
    $g = [$Games, $options->toArray()];

    return view('survivor.show', ['games'=>$g[1]]);


    }
    public function showByPool(Request $request, Pool $pool)
    {
        /*
        if (! Gate::allows('view-survivor', $pool)) {
            if (! Gate::allows('view-eliminated', $pool)) {
            return redirect()->route('mypools');  
            }
            return redirect()->route('survivor.eliminated', ['pool' => $pool]);  
        }


        $Schedule = WagerQuestion::all()->where('week', 3);

        return view('survivor.index', [
                'schedule' => $Schedule,
                'pool' => $pool,
        ]);
         */


        return view('survivor.show', [
            'pool' => $pool,
            'ticket' => Auth::user()
                ->survivorPools
                ->where('pool_id', $pool->id)
                ->first(),
        ]);
        
    }

    public function viewEliminated(Request $request, Pool $pool) {


        if (! Gate::allows('view-eliminated', $pool)) {
            return redirect()->route('survivor', ['pool' => $pool]);
        }

        return view('survivor.eliminated', ['pool' => $pool]);
    }

    public function subscribe(Request $requst)
    {   
    

    return view('survivor.purchase', ['pools' => Pool::All(), ]);


    }

    public function order(Request $request)
    {


        $pool = Pool::Find($request->input('pool'));

        if ($pool->id == 1) {
        $roleid = 2;
        $permission = ['bet alpha', 'view alpha'];
        event(new ModifySurvivorEvent(Auth::user(), $roleid, $permission, "AddRole"));
        $request->session()->put('newalpha', '1');

        //return view('survivor.home');
        return redirect()->route('mypools');

        } else {

        $response = Http::accept('application/json')->post('https://myhost/api/createCashiersInvoice?auth_token='.env('MERCHANT_TOKEN'),[
            'user_id' => Auth::user()->id,
            'username' => Auth::user()->name,
            'amount' => $pool->cost,
            'ip' => $request->ip(),
            'duration' => $pool->name, //use this field for now to say what the user is subbing to
            'product' =>Auth::user()->id,
            'type'=> 1,
        ]);

        if ($response->ok())
        {
        $url = $response->json('invoice_url');
        return redirect()->away("$url");
        } else {
        return back()->with('error','Request timed out, please try again');
        }
        }

    }

    public function viewDemo()
    {

        if (Auth::guest()) {
        $user = User::Find(14);
        auth()->login($user, true);
        }

        //$pool = Survivor::Where('pool', 1)->firstorFail();
        $pool = Pool::Find(4);
    

        $Schedule = WagerQuestion::all()->where('week', 1);

            return view('survivor.index', [
                'schedule' => $Schedule,
                'pool' => $pool,
            ]);
    }

    public function myPools()
    {

    $pools = Auth::user()->pools;

    return view('mypools', [
                'pools' => $pools,
            ]);
    }

     public function viewTest()
    {

        if (Auth::guest()) {
        $user = User::Find(14);
        auth()->login($user, true);
        }

        //$pool = Survivor::Where('pool', 1)->firstorFail();
        $pool = Pool::Find(1);
    

        $Schedule = WagerQuestion::all()->where('week', 1);

            return view('survivor.index', [
                'schedule' => $Schedule,
                'pool' => $pool,
            ]);
    }
}
