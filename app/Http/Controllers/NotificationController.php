<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'super_admin') {

            $notifications = Notification::latest()
                ->take(10)
                ->get();

        } else {

            $notifications = Notification::where('dapur_id', $user->dapur_id)
                ->latest()
                ->take(10)
                ->get();
        }

        return view('components.notification-dropdown', compact('notifications'));
    }

    public function read($id)
    {
        $notif = Notification::findOrFail($id);

        $notif->update([
            'is_read' => true
        ]);

        return response()->json([
            'status' => 'success'
        ]);
    }
}