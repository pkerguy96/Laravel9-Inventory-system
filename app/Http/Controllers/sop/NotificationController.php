<?php

namespace App\Http\Controllers\sop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\notifications;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function allnotifications()
    {
        $notifications = notifications::where('user_id', Auth::user()->id)->paginate(5);
        return view('backend.notifications.all_notifications', compact('notifications'));
    }
}
