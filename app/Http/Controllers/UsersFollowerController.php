<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class UsersFollowerController extends Controller
{
    public function follow(User $user){
        $curloginuser = Auth::user();
        $curloginuser->followings()->attach($user);

        session()->flash('success','Followed Successfully.');
        return redirect()->back();
    }

    public function unfollow(User $user){
        $curloginuser = Auth::user();
        $curloginuser->followings()->detach($user);

        session()->flash('success','Unfollowed Successfully.');
        return redirect()->back();
    }
}
