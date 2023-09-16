<?php

namespace App\Http\Controllers;

use App\Models\Bucket;
use App\Models\Ball;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BucketController extends Controller
{
    /**
     * Display a list of all buckets.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retrieve all buckets
        $buckets = Bucket::all();

        // Display the 'buckets.index' view with the list of buckets
        return view('buckets.index', compact('buckets'));
    }

    /**
     * Show the form for creating a new bucket.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Display the 'buckets.create' view for creating a new bucket
        return view('buckets.create');
    }

    /**
     * Store a newly created bucket in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:30|unique:buckets',
            'capacity' => 'required|numeric|gt:0',
        ]);

        // Create a new bucket instance
        $bucket = new Bucket();
        $bucket->name = $request->input('name');
        $bucket->capacity = $request->input('capacity');
        $bucket->save();

        // Reset the 'filled_value' for all buckets to 0
        DB::table('buckets')->update(['filled_value' => 0]);

        // Redirect to the create bucket form with a success message
        return redirect()->route('buckets.create')->with('success', 'Bucket created successfully');
    }

    /**
     * Suggest buckets to accommodate selected quantities of balls.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function suggest(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'quantities' => 'required|array',
            'quantities.*' => 'integer', // Each quantity should be an integer
        ]);

        $quantities = $request->input('quantities');
        $buckets = Bucket::all();
        $suggestions = [];

        if ($quantities !== null) {
            // Initialize remaining capacity for each bucket
            $remainingCapacityPerBucket = [];

            foreach ($buckets as $bucket) {
                // Calculate remaining capacity as the difference between bucket capacity and filled value
                $remainingCapacityPerBucket[$bucket->id] = $bucket->capacity - $bucket->filled_value;
            }

            foreach ($quantities as $ballId => $quantity) {
                $ball = Ball::find($ballId);

                if (!$ball) {
                    continue; // Skip if the ball is not found
                }

                $requiredCapacityPerBall = $ball->size * $quantity;
                $allocated = false;

                // First, check if there is a bucket with exactly the required capacity
                foreach ($buckets as $bucket) {
                    if ($requiredCapacityPerBall === $remainingCapacityPerBucket[$bucket->id]) {
                        $usedCapacity = $requiredCapacityPerBall;
                        $remainingCapacityPerBucket[$bucket->id] -= $usedCapacity;
                        $requiredCapacityPerBall = 0;

                        // Update the filled value for the bucket
                        $bucket->filled_value += $usedCapacity;
                        $bucket->save();

                        // Create a suggestion for this bucket
                        $suggestions[] = [
                            'bucket_id' => $bucket->id,
                            'bucket_name' => $bucket->name,
                            'remaining_space' => $remainingCapacityPerBucket[$bucket->id],
                        ];

                        $allocated = true;
                        break;
                    }
                }

                // If no bucket with exact capacity, try to find a bucket with matching or greater capacity
                if (!$allocated) {
                    foreach ($buckets as $bucket) {
                        if ($requiredCapacityPerBall <= $remainingCapacityPerBucket[$bucket->id]) {
                            $usedCapacity = $requiredCapacityPerBall;
                            $remainingCapacityPerBucket[$bucket->id] -= $usedCapacity;
                            $requiredCapacityPerBall = 0;

                            // Update the filled value for the bucket
                            $bucket->filled_value += $usedCapacity;
                            $bucket->save();

                            $bucketIndex = array_search($bucket->id, array_column($suggestions, 'bucket_id'));

                            if ($bucketIndex === false) {
                                // Create a suggestion for this bucket if not already suggested
                                $suggestions[] = [
                                    'bucket_id' => $bucket->id,
                                    'bucket_name' => $bucket->name,
                                    'remaining_space' => $remainingCapacityPerBucket[$bucket->id],
                                ];
                            }

                            $allocated = true;
                            break;
                        }
                    }
                }

                // If no bucket can accommodate the entire ball's capacity, report it
                if (!$allocated) {
                    $suggestions[] = [
                        'bucket_id' => null,
                        'bucket_name' => 'No bucket can accommodate',
                        'remaining_space' => 0,
                    ];
                }
            }
        }

        // Calculate remaining space in each bucket
        foreach ($buckets as $bucket) {
            $remainingSpace = $remainingCapacityPerBucket[$bucket->id];

            if ($remainingSpace > 0) {
                $bucketIndex = array_search($bucket->id, array_column($suggestions, 'bucket_id'));

                if ($bucketIndex === false) {
                    // Create a suggestion for this bucket if not already suggested
                    $suggestions[] = [
                        'bucket_id' => $bucket->id,
                        'bucket_name' => $bucket->name,
                        'remaining_space' => $remainingSpace,
                    ];
                }
            }
        }

        // Load the 'buckets.suggest' view with suggestions data
        return view('buckets.suggest', compact('suggestions'));
    }

}
