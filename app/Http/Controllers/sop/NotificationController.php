<?php

namespace App\Http\Controllers\sop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\notifications;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function allnotifications()
    {
        try {
            $notifications = notifications::where('user_id', Auth::user()->id)->paginate(5);
            return view('backend.notifications.all_notifications', compact('notifications'));
        } catch (\Exception $e) {
            Log::error('allnotifications function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
}
