<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(School $school)
{
    $reviews = Cache::remember(
        "school_reviews_{$school->id}",
        now()->addHour(),
        function () use ($school) {
            return $school->reviews()
                ->with('user')
                ->latest()
                ->get();
        }
    );

    return ReviewResource::collection($reviews);
}

    /**
     * Store a newly created resource in storage.
     */
   
public function store(Request $request, School $school)
{
    $validated = $request->validate([
        'rating' => 'required|integer|between:1,5',
        'comment' => 'required|string|max:1000',
    ]);

    if (!Auth::guard('api')->check()) {
        return response()->json([
            'message' => 'Unauthenticated.'
        ], 401);
    }

    $review = Review::create([
        'user_id'   => Auth::guard('api')->id(),
        'school_id' => $school->id,
        'rating'    => $validated['rating'],
        'comment'   => $validated['comment'],
    ]);

    $review->load('user', 'school');

    Cache::flush();

    return response()->json([
        'message' => 'Review created successfully.',
        'data' => new ReviewResource($review),
    ], 201);
}

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
     return new ReviewResource(
        $review->load('user','school')
    );
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, Review $review)
{
    if ($review->user_id != Auth::guard('api')->id()) {
        return response()->json([
            'message' => 'Unauthorized.'
        ], 403);
    }

    $validated = $request->validate([
        'rating' => 'required|integer|between:1,5',
        'comment' => 'required|string|max:1000',
    ]);

    $review->update($validated);

    Cache::flush();

    return response()->json([
        'message' => 'Review updated successfully.',
        'data' => new ReviewResource($review),
    ], 200);
}

    /**
     * Remove the specified resource from storage.
     */
public function destroy(Review $review)
{
    if ($review->user_id != Auth::guard('api')->id()) {
        return response()->json([
            'message' => 'Unauthorized.'
        ], 403);
    }

    $review->delete();

    Cache::flush();

    return response()->json([
        'message' => 'Review deleted successfully.'
    ], 200);
}

    public function userReviews(User $user)
{
    return ReviewResource::collection(
        $user->reviews()->with('school')->latest()->get()
    );
}
}
 