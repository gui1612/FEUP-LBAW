<?php

namespace App\Http\Controllers;

use App\Events\UpdateNotifications;
use App\Models\Post;
use App\Models\Forum;
use App\Models\Comment;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReportsController extends Controller {
    public function show_reports() {
        $reports = Report::orderBy('created_at', 'desc')->paginate(20);
        return view('pages.admin.reports', ['paginator'=>$reports]);
    }

    public function show_report(Report $report) {
        return view('pages.admin.report', ['report'=>$report]);
    }

    public function ongoing(Report $report) {
        $this->authorize('change_report_state', Admin::class);

        $report->state = 'ongoing';
        $report->save();

        return redirect()->back();
    }

    public function approved(Report $report) {
        $this->authorize('change_report_state', Admin::class);

        $report->state = 'approved';
        $report->save();

        if ($report->type == 'post') {
            UpdateNotifications::dispatch($report->post->owner, 'new');
        } else if ($report->type == 'comment') {
            UpdateNotifications::dispatch($report->comment->owner, 'new');
        } else {
            foreach ($report->forum->owners as $owner) {
                UpdateNotifications::dispatch($owner, 'new');
            }
        }

        return redirect()->back();
    }

    public function denied(Report $report) {
        $this->authorize('change_report_state', Admin::class);

        $report->state = 'denied';
        $report->save();

        return redirect()->back();
    }

    public function post_report(Request $request, Post $post) {
        $this->authorize('view', $post);
        $this->authorize('report', $post);
        
        $data = $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $report = new Report();
        $report->reason = $data['reason'];
        $report->type = 'post';
        $report->post()->associate($post);
        $report->owner()->associate(Auth::user());
        $report->save();

        return redirect()->back();
    }

    public function comment_report(Request $request, Post $post, Comment $comment) {
        if ($comment->post->id != $post->id) {
            return abort(404);
        }

        $this->authorize('view', $comment);
        $this->authorize('report', $comment);

        $data = $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $report = new Report();
        $report->reason = $data['reason'];
        $report->type = 'comment';
        $report->comment()->associate($comment);
        $report->owner()->associate(Auth::user());
        $report->save();

        return $report;
        return redirect()->back();
    }

    public function forum_report(Request $request, Forum $forum)
    {
        $this->authorize('view', $forum);
        $this->authorize('report', $forum);

        $data = $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $report = new Report();
        $report->reason = $data['reason'];
        $report->type = 'forum';
        $report->forum()->associate($forum);
        $report->owner()->associate(Auth::user());
        $report->save();

        return redirect()->back();
    }
}