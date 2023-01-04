@extends('layouts.app')

@section('title', 'Reports')

@section('content')
    <section class="container-fluid">
        <div class="container bg-white my-3 p-3 pb-4">
            <h3>Report</h3>
            <p>
                Reported by: <a href="{{ route('user.show', ['user'=>$report->owner]) }}" class="wt-hoverable">{{ $report->owner->username }}</a>
                <br/>
            </p>

            <h5>State</h5>
            @if($report->state == 'proposed')
                <p class="text-primary fs-5">Proposed</p>
            @elseif($report->state == 'denied')
                <p class="text-danger fs-5">Denied</p>
            @elseif($report->state == 'approved')
                <p class="text-success fs-5">Approved</p>
            @else
                <p class="text-warning fs-5">Ongoing</p>
            @endif

            <h5>Reason</h5>
            <p>{{ $report->reason }}</p>

            <h5>Actions</h5>
            <div class="d-flex flex-md-row flex-column gap-3">
                @if($report->post != NULL)
                <a href="{{ route('post', ['post'=>$report->post, 'forum'=>$report->post->forum]) }}" class="btn btn-primary d-flex align-items-center gap-2">View post
                <i class="bi bi-arrow-right-circle"></i>
                </a>
                @elseif($report->comment != NULL)
                <a href="{{ route('post', ['post'=>$report->comment->post, 'forum'=>$report->comment->post->forum]) }}" class="btn btn-primary d-flex align-items-center gap-2" style="width: max-content">View comment
                <i class="bi bi-arrow-right-circle"></i>
                </a>
                @elseif($report->forum != NULL)
                <a href="{{ route('forum.show', ['forum'=>$report->forum]) }}" class="btn btn-primary d-flex align-items-center gap-2">View forum
                <i class="bi bi-arrow-right-circle"></i>
                </a>
                @endif

                @if ($report->state == 'proposed')
                <form method="POST" action="{{ route('admin.reports.ongoing', ['report'=>$report]) }}">
                    @csrf
                    @method('PUT')
                    <button class="d-flex gap-2 align-items-center btn btn-warning" type="submit">
                        <i class="bi bi-exclamation-circle"></i>
                        Mark as Ongoing
                    </button>
                </form>
                @endif
                <form method="POST" action="{{ route('admin.reports.approved', ['report'=>$report]) }}">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="d-flex gap-2 align-items-center btn btn-success">
                        <i class="bi bi-check-circle"></i>
                        Mark as Resolved
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.reports.denied', ['report'=>$report]) }}">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="d-flex gap-2 align-items-center btn btn-danger">
                        <i class="bi bi-x-circle"></i>
                        Mark as Denied
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection