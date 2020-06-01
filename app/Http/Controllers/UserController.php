<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('club')
            ->orderBy('name')
            ->paginate(10);

        return view('users', [ 'users' => $users]);
    }

    public function show(Request $request)
    {
        $users = User::with('club')
            ->search($request['term'])
            ->orderBy('name')
            ->paginate(10);

        return view('users', [ 'users' => $users]);
    }
}
