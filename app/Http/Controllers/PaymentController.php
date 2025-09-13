<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userPayments = $this->getUserPayments($request);
        $allPayments  = $this->getAllPayments($request);

        return response()->json([
            'user_payments' => $userPayments,
            'all_payments'  => $allPayments,
        ]);
    }

    /**
     * Get payments of logged-in user
     */
    private function getUserPayments(Request $request)
    {
        $search = $request->query('search');
        $userId = Auth::id();

        $query = Payment::where('member_id', $userId);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('amount', 'like', "%{$search}%")
                    ->orWhere('created_at', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate(5);
    }

    /**
     * Get all payments
     */
    private function getAllPayments(Request $request)
    {
        $search = $request->query('search');

        $query = Payment::with(['member']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('member', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })
                    ->orWhere('amount', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('created_at', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate(5);
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
    public function show(string $id)
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
