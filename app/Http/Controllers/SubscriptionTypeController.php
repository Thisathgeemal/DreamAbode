<?php
namespace App\Http\Controllers;

use App\Models\SubscriptionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = SubscriptionType::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('type_name', 'like', "%{$search}%")
                    ->orWhere('duration_days', 'like', "%{$search}%")
                    ->orWhere('base_amount', 'like', "%{$search}%")
                    ->orWhere('discount_percent', 'like', "%{$search}%")
                    ->orWhere('final_price', 'like', "%{$search}%");
            });
        }

        $subscriptions = $query->orderBy('final_price', 'asc')->paginate(5);

        return response()->json($subscriptions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type_name'        => 'required|string|max:255',
            'duration_days'    => 'required|integer|min:1',
            'base_amount'      => 'required|numeric|min:0',
            'discount_percent' => 'required|numeric|min:0|max:100',
        ]);

        DB::beginTransaction();

        try {
            $finalPrice = $request->base_amount - ($request->base_amount * $request->discount_percent / 100);

            $subscription = SubscriptionType::create([
                'type_name'        => $request->type_name,
                'duration_days'    => $request->duration_days,
                'base_amount'      => $request->base_amount,
                'discount_percent' => $request->discount_percent,
                'final_price'      => $finalPrice,
            ]);

            DB::commit();

            return response()->json([
                'success' => 'Subscription type created successfully!',
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subscription = SubscriptionType::find($id);

        if (! $subscription) {
            return response()->json(['message' => 'Subscription plan not found'], 404);
        }

        return response()->json($subscription);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'type_name'        => 'required|string|max:255',
            'duration_days'    => 'required|integer|min:1',
            'base_amount'      => 'required|numeric|min:0',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
        ]);

        $subscription = SubscriptionType::find($id);

        if (! $subscription) {
            return response()->json(['error' => 'Subscription plan not found'], 404);
        }

        DB::beginTransaction();

        try {
            $finalPrice = $request->base_amount - ($request->base_amount * $request->discount_percent / 100);

            $subscription->update([
                'type_name'        => $request->type_name,
                'duration_days'    => $request->duration_days,
                'base_amount'      => $request->base_amount,
                'discount_percent' => $request->discount_percent ?? 0,
                'final_price'      => $finalPrice,
            ]);

            DB::commit();
            return response()->json(['success' => 'Subscription updated successfully!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Something went wrong! Contact support service'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subscription = SubscriptionType::find($id);

        if (! $subscription) {
            return response()->json([
                'error' => 'Subscription type not found',
            ], 404);
        }

        try {
            $subscription->delete();
            return response()->json([
                'success' => 'Subscription type deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong! Contact support service',
            ], 500);
        }
    }
}
