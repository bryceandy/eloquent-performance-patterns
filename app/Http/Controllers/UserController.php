<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('club')
            ->orderBy('name')
            ->paginate(10);

        return view('users', [ 'users' => $users]);
    }
}
