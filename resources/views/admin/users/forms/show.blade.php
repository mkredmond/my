<form action="{{ url('admin/users', [ $user->id ]) }}" method="POST" class="form-horiztonal">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="form-group col-xs-12">
        <label class="control-label col-md-2" for="role">
            Role
        </label>
        <div class="col-md-4">
            <select name="role" id="role" class="form-control">
                @foreach ($roles as $role)
                <option value="{{ $role->name }}" {{ $user->role_id == $role->id ?  'selected=selected' : '' }}>
                    {{ $role->label }}
                </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group col-xs-12">
        <label class="control-label col-md-2">
            Email
        </label>
        <p class="form-control-static col-md-4">
            {{ $user->email }}
        </p>
    </div>
    <div class="form-group col-xs-12">
        <label class="control-label col-md-2">
            Title
        </label>
        <p class="form-control-static col-md-4">
            {{ $user->title }}
        </p>
    </div>
    <div class="form-group col-xs-12">
        <label class="control-label col-md-2">
            Created At
        </label>
        <p class="form-control-static col-md-4">
            {{ date_format($user->created_at, 'F j, Y') }}
        </p>
    </div>
    <div class="form-group col-xs-12">
        <label class="control-label col-md-2">
            Last Login
        </label>
        <p class="form-control-static col-md-4">
            {{ date_format($user->updated_at, 'F j, Y') }}
        </p>
    </div>
    <div class="form-group pull-right">
        <input type="submit" name="update" id="update" class="btn btn-success" value="Update"/>
    </div>
</form>
