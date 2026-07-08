<?php

namespace App\Http\Controllers;

use App\Http\Resources\FavoriteResource;
use App\Models\Favorite;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * GET /api/favorites
     */


public function index()
{
       $favorites = Favorite::with([
            'school' => function ($query) {
                $query->withAvg('reviews', 'rating');
            }
        ])
        ->where('user_id', Auth::guard('api')->id())
        ->get();

        return FavoriteResource::collection($favorites);
}


    /**
     * POST /api/favorites
     */
   public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
        ]);

        $favorite = Favorite::firstOrCreate([
            'user_id'   => Auth::guard('api')->id(),
            'school_id' => $validated['school_id'],
        ]);

        if (!$favorite->wasRecentlyCreated) {
            return response()->json([
                'message' => 'School already exists in favorites.'
            ], 409);
        }

        return response()->json([
            'message' => 'School added to favorites successfully.'
        ], 201);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'message' => 'Validation failed.',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        return response()->json([
            'message' => $e->getMessage()
        ], 500);
    }
}

    /**
     * DELETE /api/favorites/{school}
     */
    public function destroy($school)
    {
        $favorite = Favorite::where('user_id', Auth::guard('api')->id())
            ->where('school_id', $school)
            ->first();

        if (!$favorite) {
            return response()->json([
                'message' => 'Favorite not found.'
            ], 404);
        }

        $favorite->delete();

        return response()->json([
            'message' => 'School removed from favorites successfully.'
        ], 200);
    }
}