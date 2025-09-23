<?php
namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userSubscriptions = $this->getUserSubscriptions($request);
        $allSubscriptions  = $this->getAllSubscriptions($request);

        return response()->json([
            'user_subscriptions' => $userSubscriptions,
            'all_subscriptions'  => $allSubscriptions,
        ]);
    }

    /**
     * Get subscriptions of logged-in user
     */
    private function getUserSubscriptions(Request $request)
    {
        $search = $request->query('search');
        $userId = Auth::id();

        $query = Subscription::with(['member', 'subscriptionType'])
            ->where('member_id', $userId);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('member', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })
                    ->orWhereHas('subscriptionType', function ($q2) use ($search) {
                        $q2->where('type_name', 'like', "%{$search}%");
                    })
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('start_date', 'like', "%{$search}%")
                    ->orWhere('end_date', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('end_date', 'asc')->paginate(5);
    }

    /**
     * Get all subscriptions
     */
    private function getAllSubscriptions(Request $request)
    {
        $search = $request->query('search');

        $query = Subscription::with(['member', 'subscriptionType']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('member', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })
                    ->orWhereHas('subscriptionType', function ($q2) use ($search) {
                        $q2->where('type_name', 'like', "%{$search}%");
                    })
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('start_date', 'like', "%{$search}%")
                    ->orWhere('end_date', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('end_date', 'asc')->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'amount'      => 'required|numeric|min:1',
            'type_id'     => 'required|exists:subscription_types,type_id',
            'action'      => 'nullable|in:cancel_old,wait_old',
            'card_type'   => 'required|in:visa,mastercard,amex,discover',
            'card_name'   => 'required|string|max:255',
            'card_number' => 'required|digits:16',
            'cvv'         => 'required|digits:3',
            'expiry_date' => ['required', 'date_format:Y-m', function ($attribute, $value, $fail) {
                [$year, $month] = explode('-', $value);
                $expiry         = \Carbon\Carbon::create($year, $month, 1)->endOfMonth();
                if ($expiry < now()) {
                    $fail('The expiry date must be today or in the future.');
                }
            }],
        ]);

        DB::beginTransaction();
        try {
            $type = SubscriptionType::findOrFail($validated['type_id']);

            // Check for active subscription
            $active = Subscription::where('member_id', $user->id)
                ->where('status', 'active')
                ->whereDate('end_date', '>=', now())
                ->first();

            if ($active && ! isset($validated['action'])) {
                DB::rollBack();
                return response()->json([
                    'message'             => 'You already have an active subscription.',
                    'active_subscription' => $active,
                    'required_action'     => ['wait_old', 'cancel_old'],
                ], 409);
            }

            // Create payment record
            $payment = Payment::create([
                'member_id'   => $user->id,
                'amount'      => $validated['amount'],
                'title'       => 'Buy Subscription',
                'description' => 'Payment for subscription type: ' . $type->type_name,
            ]);

            Notification::create([
                'user_id' => $user->id,
                'title'   => 'Payment Successful',
                'message' => 'Your payment for buy Subscription was processed successfully.',
                'type'    => 'payment',
                'is_read' => false,
            ]);

            // Default: new subscription starts today
            $startDate = now()->startOfDay();
            $endDate   = $startDate->copy()->addDays($type->duration_days - 1)->endOfDay();
            $status    = 'active';

            if ($active) {
                if ($validated['action'] === 'cancel_old') {
                    // Cancel the old subscription
                    $active->update(['status' => 'canceled']);

                    $startDate = now()->startOfDay();
                    $endDate   = $startDate->copy()->addDays($type->duration_days - 1)->endOfDay();
                    $status    = 'active';

                    // Recalculate pending subscriptions
                    $pendingSubs = Subscription::where('member_id', $user->id)
                        ->where('status', 'pending')
                        ->orderBy('start_date')
                        ->get();

                    $currentEnd = $endDate->copy();

                    foreach ($pendingSubs as $pending) {
                        $newStart        = $currentEnd->copy()->addDay()->startOfDay();
                        $pendingDuration = $pending->start_date->diffInDays($pending->end_date) + 1;
                        $newEnd          = $newStart->copy()->addDays($pendingDuration - 1)->endOfDay();

                        $pending->update([
                            'start_date' => $newStart,
                            'end_date'   => $newEnd,
                        ]);

                        $currentEnd = $newEnd->copy();
                    }

                } elseif ($validated['action'] === 'wait_old') {
                    $startDate = $active->end_date->copy()->addDay()->startOfDay();
                    $endDate   = $startDate->copy()->addDays($type->duration_days - 1)->endOfDay();
                    $status    = 'pending';
                }
            }

            // Create new subscription
            $subscription = Subscription::create([
                'member_id'  => $user->id,
                'type_id'    => $type->type_id,
                'payment_id' => $payment->payment_id,
                'start_date' => $startDate,
                'end_date'   => $endDate,
                'status'     => $status,
            ]);

            Notification::create([
                'user_id' => $user->id,
                'title'   => 'Subscription Activated',
                'message' => 'Your subscription has been activated successfully.',
                'type'    => 'membership',
                'is_read' => false,
            ]);

            DB::commit();

            return response()->json([
                'success' => 'Subscription created successfully.',
            ], 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Subscription creation failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create subscription'], 500);
        }
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
        $subscriptionIds = $request->input('subscription_ids', []);

        if ($id) {
            $subscriptionIds[] = (int) $id;
        }

        $validator = Validator::make(['subscription_ids' => $subscriptionIds], [
            'subscription_ids'   => 'required|array|min:1',
            'subscription_ids.*' => 'integer|exists:subscriptions,subscription_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Invalid subscription IDs.',
            ], 422);
        }

        $subscriptions = Subscription::whereIn('subscription_id', $subscriptionIds)->get();

        Subscription::whereIn('subscription_id', $subscriptionIds)->update([
            'status' => 'canceled',
        ]);

        foreach ($subscriptions as $subscription) {
            Notification::create([
                'user_id' => $subscription->member_id,
                'title'   => 'Subscription Cancelled',
                'message' => 'Your subscription has been cancelled successfully.',
                'type'    => 'membership',
                'is_read' => false,
            ]);
        }

        return response()->json([
            'success' => 'Subscription(s) cancelled successfully.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
