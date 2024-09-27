<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BetSlip;

class BettingPortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('betslips.index', [
                'betslips' => Auth::user()->betslips()
                ->orderBy('id', 'desc')
                ->paginate(10)
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
    public function show(BetSlip $betslip)
    {
        dd($betslip);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BetSlip $betslip)
    {
        if($betslip->user_id === Auth::user()->id) {
            return view('betslips.edit', ['betslip' => $betslip]);
        }

        return abort(403);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BetSlip $betslip)
    {

        //dd($request->input()['result']);


        
        if($betslip->user_id === Auth::user()->id) {

            if(isset($request->input()['result']) && $request->input()['result'] === "null")
            {
                $betslip->result = null;
                $betslip->save();
                $input = $request->except('result');
                //dd($input);
                $betslip->update($input);
            } else {
                $betslip->update($request->input());
            }
            
            return redirect()->route('betslip.index');

        } else {
           return abort(403); 
        }

    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BetSlip $betslip)
    {
        if($betslip->user_id === Auth::user()->id) {
            $betslip->delete();
            return back();
        } else {
            return abort(403);
        }
        
    }
}
