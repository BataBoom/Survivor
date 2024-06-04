<?php

namespace App\Http\Controllers;

use App\Models\Pool;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        return view('chatroom.show', ['pool' => $pool, 'games' => Auth::user()->pools]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pool $pool)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pool $pool)
    {
        Message::Create([
            'pool_chat_id' => $pool->id,
            'from_id' => $request->input('from'),
            'text' => $request->input('message'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pool $pool)
    {
        //
    }
}
