@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Users
                </div>
                <div class="panel-body">
                    <ul>
                        @foreach ($users as $user)
                        <li>{{ $user->surname }}, {{ $user->givenname }} ({{ $user->role->label }})</li>
                        @endforeach
                   </ul>
                   <span>Showing {{ $users->count() }} of {{ $userTotal }} users. <a href="{{ url('admin/users') }}">View all users</a></span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
