@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <p class="pull-right">
                <a href="{{ url('admin/users') }}" class="btn btn-primary">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                    Back to all users
                </a>
            </p>
            <h4>
                <strong>
                    {{ $user->givenname }} {{ $user->surname }}
                </strong>
            </h4>
            <hr/>
            @include('admin.users.forms.show')

            @if ($user->user_type == "Local")
                <a href="{{ url('home') }}" class="btn btn-warning">Reset Password</a>
            @endif
            
        </div>
    </div>
</div>
@stop
