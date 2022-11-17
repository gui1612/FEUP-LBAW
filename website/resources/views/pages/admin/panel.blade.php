@extends('layouts.admin')

@section('title', 'Admin Panel')

@section('content')
    <section>
        <h2>Administration Team</h2>
        <ul>
            @foreach ($admins as $admin)
                <li>
                    <div>
                        {{ $admin->username }}
                    </div>
                </li>
            @endforeach
        </ul>
        {{ $admins }}
    </section>
@endsection