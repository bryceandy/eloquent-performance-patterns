<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show a user's friend
     *
     * @return Factory|View
     */
    public function index()
    {
        auth()->user()->load('club', 'buddies');

        $friends = User::with('club')
            //->withLastTripDate()
            //->withLastTripLake()
            ->withLastTrip()
            ->visibleTo(auth()->user())
            ->orderByBuddiesFirst(auth()->user())
            ->orderBy('name')
            ->paginate(10);

        return view('home', ['friends' => $friends]);
    }
}
