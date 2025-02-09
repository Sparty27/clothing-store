<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);

        return view('admin.pages.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.pages.users.edit', compact('user'));
    }
}
