<?php

namespace App\Http\Controllers;

use App\Models\Pool;
use App\Models\SurvivorRegistration;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\CreatePoolRequest;
use Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Http\Services\InvoiceGenerator;
use App\Models\DummyPool;

class PoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $officialPools = Config::get('survivor.dummy_pools') ? DummyPool::getPromoPoolsForController() : Pool::Where('creator_id', 1)->withCount('users')->orderBy('users_count', 'desc')->paginate(5);

        return view('pools.index', [
            'pools' => Pool::Where('public', true)
                ->Where('hidden', false)
                ->WhereNotNull('creator_id')
                ->withCount('users')
                ->orderBy('users_count', 'desc')
                ->paginate(10),
            'start_date' => Config::get('survivor.start_date'),
            'sitePools' => $officialPools,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pools.create', ['types' => Pool::TYPES, 'prizetypes' => Pool::PRIZETYPES]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePoolRequest $request)
    {

        $validated = $request->validated();

        /*
        dd($validated);
        $create = Pool::create(
            $validated
        );
        */
        if(config::get('survivor.payments') !== true) {

            $create = Pool::create(
                $validated
            );

            $request->session()->flash('success', 'Created & Registered in Pool: '. $create->name);

            SurvivorRegistration::Create([
                'user_id' => Auth::user()->id,
                'pool_id' => $create->id,
                'alive' => true,
                'lives_count' => $create->lives_per_person,
            ]);

            return redirect()->route('mypools.show');

        }
        //ELSE
        if($validated['entry_cost'] == 0 && $validated['guaranteed_prize'] == 0) {

            $create = Pool::create(
                $validated
            );

            $request->session()->flash('success', 'Created & Registered in Pool: '. $create->name);

            SurvivorRegistration::Create([
                'user_id' => Auth::user()->id,
                'pool_id' => $create->id,
                'alive' => true,
                'lives_count' => $create->lives_per_person,
            ]);

            return redirect()->route('mypools.show');


        } elseif($validated['entry_cost'] !== 0 || $validated['guaranteed_prize'] !== 0) {

           $create = Pool::create(
                $validated
            );

            $request->session()->flash('success', 'Pool Created Successfully.');

            return redirect()->route('forbidden.pool', ['pool' => $create->id]);

        } else {

            $request->session()->flash('errors', 'Error Creating Pool. Try again.');

            return redirect()->back()
                ->withErrors($validated)
                ->withInput();
        }
              
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Pool $pool)
    {

        if($pool->type === 'survivor') {
            return redirect()->route('survivor.show', ['pool' => $pool]);
        } elseif($pool->type === 'pickem') {
            return redirect()->route('pickem.wire', ['pool' => $pool]);
        } else {
            return view('where am i');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Pool $pool)
    {
        return view('pools.edit', ['pool' => $pool, 'type' => ucfirst($pool->type), 'start_date' =>Config::get('survivor.start_date'), 'contenders' => $pool->contenders]);
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
    public function destroy(Request $request, Pool $pool)
    {


        if ($request->user()->cannot('delete', $pool)) {
            abort(403);
        } else {

            if(now()->lessThan(Config::get('survivor.start_date'))) {
                $poolCopy = $pool->toArray();

                if($pool->delete()) {
                    $request->session()->flash('success', 'Pool: '.$poolCopy['name'].' Deleted Successfully');
                }

                return redirect()->route('mypools.show');
            } else {

                $request->session()->flash('error', 'Season started cannot delete pool');
                return redirect()->route('mypools.show');
            }
        }
    }

    public function register(Request $request, Pool $pool) {

        if(now()->lessThan(Config::get('survivor.start_date')) && $pool->entry_cost == 0) {
            $register = $pool->registration()->create([
                'user_id' => Auth::user()->id,
                'alive' => true,
                'lives_count' => 1,
            ]);

            if ($register->id) {
                $request->session()->flash('success', 'Success! Registered to: ' . $pool->name);
                return redirect()->route('mypools.show');
            }
        } elseif(now()->lessThan(Config::get('survivor.start_date')) && $pool->entry_cost > 0) {

            $payment = new InvoiceGenerator(Auth::user(), $pool);
            $paymentURL = $payment->makeInvoice();
            return redirect()->away($paymentURL);

        } else {

            return back()->withErrors('Registration has concluded!');
        }
    }

    public function finishSetup(Request $request, Pool $pool)
    {

        $payment = new InvoiceGenerator(Auth::user(), $pool);
        $paymentURL = $payment->makeInvoice();
        return redirect()->away($paymentURL);

        //$setupCost = number_format($pool->entry_cost + $pool->guaranteed_prize, 2);

        //return view('checkout.setup', ['pool' => $pool, 'setupCost' => $setupCost]);
    }

    public function leave(Request $request, SurvivorRegistration $survivorregistration) {

        $pool = $survivorregistration->pool;

        if($survivorregistration->pool->type === 'survivor' && $survivorregistration->alive && now()->greaterThan(Config::get('survivor.start_date'))) {

            $request->session()->flash('error', "Error you're still alive! Cannot leave pool: ". $pool->name);
            return redirect()->route('mypools.show');

        }

        if($survivorregistration->pool->type === 'survivor' && now()->lessThan(Config::get('survivor.start_date'))) {


            $leave = $survivorregistration->delete();

            if ($leave) {
                $request->session()->flash('success', 'Success! Left: ' . $pool->name);
                return redirect()->route('mypools.show');
            } else {
                $request->session()->flash('error', 'Error processing. Try again.');
                return redirect()->route('mypools.show');
            }
        }

        $leave = $survivorregistration->delete();

        if ($leave) {
            $request->session()->flash('success', 'Success! Left: ' . $pool->name);
            return redirect()->route('mypools.show');
        } else {
            $request->session()->flash('error', 'Error processing. Try again.');
            return redirect()->route('mypools.show');
        }

    }
}
