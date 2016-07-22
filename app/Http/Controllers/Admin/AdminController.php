<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:superuser');
    }

    /**
     * Show the admin landing page
     * @return view
     */
    public function index()
    {
        $users     = User::orderBy('updated_at', 'desc')->take(2)->with('role')->get();
        $userTotal = User::count();
        return view('admin.index', compact('users', 'userTotal'));
    }
}
