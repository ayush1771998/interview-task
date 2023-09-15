<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ball;
use App\Models\Bucket;
use Illuminate\Support\Facades\DB;

class BallController extends Controller
{
    /**
     * Display a list of all balls.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retrieve all balls
        $balls = Ball::all();

        // Display the 'balls.index' view with the list of balls
        return view('balls.index', compact('balls'));
    }

    /**
     * Show the form for creating a new ball.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Display the 'balls.create' view for creating a new ball
        return view('balls.create');
    }

    /**
     * Store a newly created ball in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'color' => 'required|string|max:30|unique:balls',
            'size' => 'required|numeric|gt:0',
        ]);

        // Create a new ball instance
        $ball = new Ball();
        $ball->color = $request->input('color');
        $ball->size = $request->input('size');
        $ball->save();

        // Reset the 'filled_value' for all buckets to 0
        DB::table('buckets')->update(['filled_value' => 0]);

        // Redirect to the create ball form with a success message
        return redirect()->route('balls.create')->with('success', 'Ball created successfully');
    }
}
