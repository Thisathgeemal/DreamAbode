<?php
namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userReviews    = $this->getUserReviews();
        $allReviewsData = $this->getAllReviews();

        return response()->json([
            'user_reviews'    => $userReviews,
            'all_reviews'     => $allReviewsData['all'],
            'visible_reviews' => $allReviewsData['visible'],
        ]);
    }

    /**
     * Get all reviews.
     */
    private function getAllReviews()
    {
        $reviews = Review::all();
        $userIds = $reviews->pluck('member_id')->unique()->toArray();
        $users   = User::whereIn('id', $userIds)->get()->keyBy('id');

        $allReviews = $reviews->map(function ($review) use ($users) {
            $reviewArr           = $review->toArray();
            $reviewArr['member'] = $users[$review->member_id] ?? null;
            return $reviewArr;
        });

        $visibleReviews = $allReviews->where('visibility', true)->values();

        $randomVisibleReviews = $visibleReviews->count() > 3
            ? $visibleReviews->random(3)
            : $visibleReviews;

        return [
            'all'     => $allReviews,
            'visible' => $randomVisibleReviews->values(),
        ];
    }

    /**
     * Get reviews for the logged-in user.
     */
    private function getUserReviews()
    {
        $reviews = Review::where('member_id', Auth::id())->get();
        $user    = User::find(Auth::id());
        return $reviews->map(function ($review) use ($user) {
            $reviewArr           = $review->toArray();
            $reviewArr['member'] = $user;
            return $reviewArr;
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating'      => 'required|integer|min:1|max:5',
            'description' => 'required|string',
        ]);

        $review = Review::create([
            'member_id'   => Auth::id(),
            'rating'      => $validated['rating'],
            'description' => $validated['description'],
            'visibility'  => true,
        ]);

        return response()->json(['review' => $review], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    }

    /**
     * Hide a review (set visibility to false).
     */
    public function hideReview(string $id)
    {
        $review = Review::find($id);

        if (! $review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        if (! $review->visibility) {
            return response()->json(['message' => 'Review is already hidden']);
        }

        $review->visibility = false;
        $review->save();

        return response()->json(['message' => 'Review hidden successfully']);
    }

    /**
     * Show a review (set visibility to true).
     */
    public function showReview(string $id)
    {
        $review = Review::find($id);

        if (! $review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        if ($review->visibility) {
            return response()->json(['message' => 'Review is already visible']);
        }

        $review->visibility = true;
        $review->save();

        return response()->json(['message' => 'Review is now visible']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $review = Review::find($id);
        if (! $review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        $review->delete();
        return response()->json(['message' => 'Review deleted successfully']);
    }
}
