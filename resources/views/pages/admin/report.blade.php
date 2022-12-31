@extends('layouts.app')

@section('title', 'Reports')

@section('content')
    <section class="container-fluid">
        <div class="container">
            {{ $report->owner()->username }}
        </div>
    </section>
@endsection