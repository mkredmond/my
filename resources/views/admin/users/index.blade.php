@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
        	<p>
        		<a href="{{ url('admin/users/create') }}" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Add User</a>
        	</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Users
                </div>
               
                <table class="table table-striped"> 
                	<thead>
                		<th>First Name</th>
                		<th>Last Name</th>
                        <th>Last Login</th>
                		<th>User Type</th>
                		<th></th>
                	</thead>
                	<tbody>
                		@foreach ($users as $user)
                		<tr>
                			<td>{{ $user->givenname }}</td>
                			<td>{{ $user->surname }}</td>
                            <td>{{ $user->updated_at }}</td>
                			<td>{{ $user->user_type }}</td>
                			<td><a class="pull-right" href="{{ url('admin/users', [$user->id]) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a></td>
                		</tr>
                		@endforeach
                	</tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
