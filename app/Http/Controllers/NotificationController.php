<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
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
    $notifications = $user->notifications()->orderBy('created_at', 'desc');
    return view('pages.notifications', ['paginator' => $notifications->paginate(20)]);
  }

  public function mark_as_read(Notification $notification) {
    $user = Auth::user();
    $this->authorize('update', $notification);
    $notification->update(['read' => true]);
    return redirect()->back();
  }

  public function mark_all_as_read(User $user) {
    $this->authorize('update', $user);
    $user->notifications()->update(['read' => true]);
    return redirect()->back();
  }

//   public function delete(Notification $notification) {
//     $this->authorize('delete', $notification);
//     $notification->delete();
//     return redirect()->back();
//   }

//   public function delete_all(User $user) {
//     $this->authorize('delete', $user);
//     $user->notifications()->delete();
//     return redirect()->back();
//   }

}    