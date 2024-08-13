<?php

namespace App\Http\Controllers;

use App\Models\Pool;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slides = [
        [
            'image' => asset('storage/bg-1.jpg'),
            'title' => 'Outpick, Outplay, Outlast',
        ],
        [
            'image' => asset('storage/bg-2.jpeg'),
            'title' => 'Survive, Thrive, Win 0.01 BTC',
        ],
        [
            'image' => asset('storage/bg-3.jpeg'),
            'title' => 'Become The Last Survivor',
        ],
        [
            'image' => asset('storage/bg-4.jpeg'),
            'title' => 'Outpick, Outplay, Outlast',
        ],
        [
            'image' => asset('storage/bg-5.jpg'),
            'title' => 'Survive, Thrive, Win 0.01 BTC',
        ],
        [
            'image' => asset('storage/bg-6.jpg'),
            'title' => 'Become The Last Survivor',
        ],
        [
            'image' => asset('storage/bg-7.jpg'),
            'title' => 'Become The Last Survivor',
        ],
        [
            'image' => asset('storage/bg-8.jpg'),
            'title' => 'Become The Last Survivor',
        ],
        [
            'image' => asset('storage/bg-9.jpg'),
            'title' => 'Become The Last Survivor',
        ],
        [
            'image' => asset('storage/bg-10.jpg'),
            'title' => 'Become The Last Survivor',
        ]
    ];
        shuffle($slides);
        return view ('landingv2', compact('slides'));
        
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
    public function show(Request $request)
    {

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
