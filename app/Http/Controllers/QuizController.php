<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\QuizScore;
use Illuminate\Support\Facades\Auth;


class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $q = Auth::user()->quizscores()->orderBy('id', 'desc')
                ->paginate(10);

        return view('quizes.index', ['quizes' => $q]);
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
    public function show(Quiz $quiz)
    {
         return view('quiz', ['quiz' => $quiz]);
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
