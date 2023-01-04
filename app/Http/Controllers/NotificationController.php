<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Events\UpdateNotifications;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class NotificationController extends Controller {

  public function show_notification(Notification $notification) {
    $this->authorize('view', $notification);
    return view('pages.notifications.show_notification', ['notification' => $notification]);
  }

  public function show_all() {
    $user = Auth::user();
    $notifications = $user->notifications()->where('read', 'false')->orderBy('created_at', 'desc');
    return view('pages.notifications', ['paginator' => $notifications->paginate(20)]);
  }

  public function mark_as_read(Notification $notification) {
    $user = Auth::user();
    $this->authorize('update', $notification);
    $notification->read = 'true';
    $notification->save();

    UpdateNotifications::dispatch($user, 'consistency');

    return redirect()->back();
  }

  public function mark_as_unread(Notification $notification) {
    $user = Auth::user();
    $this->authorize('update', $notification);
    $notification->read = 'false';
    $notification->save();

    UpdateNotifications::dispatch($user, 'consistency');

    return redirect()->back();
  }

  public function navbar() {
    $notifications = Auth::user()->notifications()->where('read', 'false')->orderBy('created_at', 'desc')->take(5)->get();

    $widescreen = view('partials.navbar.notifications.widescreen', ['notifications' => $notifications]);
    $mobile = view('partials.navbar.notifications.mobile', ['notifications' => $notifications]);

    return response()->json([
      'widescreen' => $widescreen->render(),
      'mobile' => $mobile->render()
    ]);
  }
}    