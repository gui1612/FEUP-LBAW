@extends('layouts.app')

@section('title', 'Reports')

@section('content')
    <section class="container-fluid">
        <div class="table-responsive">
            <table class="table table-hover caption-top">
                <h3 class="py-3">Reports</h3>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Date</th>
                        <th scope="col">Type</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="d-none d-md-table-cell">Reason</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paginator->items() as $report)
                        <tr>
                            <th scope="row">{{ $report->id }}</th>
                            <td>{{ displayDate($report->created_at) }}</td>
                            
                            <td>{{ $report->type }}</td>
                            <td>
                                @if($report->state == 'proposed')
                                <span class="text-primary">Proposed</span>
                                @elseif($report->state == 'ongoing')
                                <span class="text-warning">On Going</span>
                                @elseif($report->state == 'approved')
                                <span class="text-success">Resolved</span>
                                @else
                                <span class="text-danger">Denied</span>
                                @endif
                            </td>
                            <td class="d-none d-md-table-cell">{{ Str::limit($report->reason, 120) }}</td>
                            <td>
                                <a href="{{ route('admin.reports.report', ['report'=>$report]) }}" class="btn btn-primary d-flex align-items-center gap-2" style="width: max-content">
                                    <span class="d-none d-md-block">See details</span>
                                    <i class="bi bi-arrow-right-circle"></i>
                                </a>
                            </td>
                        </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $paginator}}
    </section>
@endsection