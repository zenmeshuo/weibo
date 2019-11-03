<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class FollowersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(User $user)
    {
        try {
            $this->authorize('follow', $user);
        } catch (AuthorizationException $e) {
            return abort(403, '无权访问');
        }

        if (! Auth::user()->isFollowing($user->id)) {
            Auth::user()->follow($user->id);
        }

        return redirect()->route('users.show', $user->id);
    }

    public function destroy(User $user)
    {
        try {
            $this->authorize('follow', $user);
        } catch (AuthorizationException $e) {
            return abort(403, '无权访问');
        }

        if (Auth::user()->isFollowing($user->id)) {
            Auth::user()->unfollow($user->id);
        }

        return redirect()->route('users.show', $user->id);
    }
}
