<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tickets.index', ['payments' => Auth::user()->payments, 'tickets' => Auth::user()->tickets]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $newTicket = Ticket::Create([
            'user_id' => Auth::user()->id,
            //'payment_id' => $request->input('payment'),
            'subject' => $request->input('subject'),
        ]);

        $newTicket->replies()->create([
            'message' => $request->input('message'),
            'user_id' => Auth::user()->id,
            'ticket_id' => $newTicket->id,
        ]);

        return redirect()->route('support.show', ['ticket' => $newTicket->id]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Ticket $ticket)
    {

        $create = $ticket->replies()->create([
            'message' => $request->input('message'),
            'user_id' => Auth::user()->id,
            'ticket_id' => $ticket->id,
        ]);

        if ($create->save()) {
            return back()->with('Post Created!');
        } else {
            dd('error');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Ticket $ticket)
    {

        return view ('tickets.show',[
            'ticket' => $ticket,
            'alltix' => Auth::user()->tickets,
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
    public function destroy(Request $request, Ticket $ticket)
    {
        if($ticket->delete()) {
            return redirect()->route('support.index');
        } else {
            return response()->json('error');
        }

    }
}