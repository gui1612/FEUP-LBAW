<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class NotificationController extends Controller {

  public function show_notification(Notification $notification) {
    $this->authorize('view', $notification);
    return view('pages.notifications.show_notification', ['notification' => $notification]);
  }

    public function show_all() {
        return view('pages.notifications');
    }

}    