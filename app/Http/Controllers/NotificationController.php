<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications for current user.
     */
    public function index(Request $request)
    {
        $query = auth()->user()->notifications();

        // Apply filters
        if ($request->filter === 'unread') {
            $query->unread();
        } elseif ($request->filter === 'review') {
            $query->where('type', 'review');
        } elseif ($request->filter === 'overdue') {
            $query->where('type', 'overdue');
        }

        $notifications = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Get unread notification count.
     */
    public function getUnreadCount()
    {
        return response()->json([
            'count' => auth()->user()->notifications()->unread()->count()
        ]);
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
        }

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        auth()->user()->notifications()->unread()->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    /**
     * Delete notification.
     */
    public function destroy($id)
    {
        $notification = auth()->user()->notifications()->find($id);

        if ($notification) {
            $notification->delete();
        }

        return response()->json(['success' => true]);
    }
}
