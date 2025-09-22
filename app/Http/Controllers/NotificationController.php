<?php
namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        return response()->json([
            'unread_notifications' => $this->getUnreadNotifications($user->id),
            'read_notifications'   => $this->getReadNotifications($user->id),
            'unread_count'         => $this->getUnreadCount($user->id),
        ]);
    }

    /**
     * Retrieve unread notifications for a user.
     */
    private function getUnreadNotifications($userId)
    {
        return Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Retrieve read notifications for a user.
     */
    private function getReadNotifications($userId)
    {
        return Notification::where('user_id', $userId)
            ->where('is_read', true)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get unread notification count for a user.
     */
    private function getUnreadCount($userId)
    {
        return Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->count();
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
        $user = $request->user();

        $notification = Notification::where('notification_id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (! $notification) {
            return response()->json([
                'message' => 'Notification not found',
            ], 404);
        }

        $notification->is_read = true;
        $notification->save();

        return response()->json([
            'message' => 'Notification marked as read',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $notification = Notification::where('notification_id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (! $notification) {
            return response()->json([
                'message' => 'Notification not found',
            ], 404);
        }

        $notification->delete();

        return response()->json([
            'message' => 'Notification deleted successfully',
        ]);
    }
}
