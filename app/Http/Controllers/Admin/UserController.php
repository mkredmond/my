<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:superuser');
    }

    /**
     * Returns full list of users
     * @return view
     */
    public function index()
    {
        $users = User::get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {

    }

    public function store()
    {

    }

    /**
     * Shows details for a user
     * @param  User   $user
     * @return view
     */
    public function show(User $user)
    {
        $roles = Role::get();
        return view('admin.users.show', compact('user', 'roles'));
    }

    /**
     * Updates the role assignment of a user
     * @param  Request $request
     * @param  User    $user
     * @return view
     */
    public function update(Request $request, User $user)
    {
        if ($user->assignRole($request->input('role'))) {
            flash()->success('User updated...', '');
        }
        return back();
    }

    public function destroy()
    {
        
    }
}
