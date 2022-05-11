<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use App\Models\Profile;
use App\Models\TweetTag;
use App\Http\Resources\TweetTagResource;
use App\Http\Resources\ProfileResource;

class FollowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth') ;
    }

    /**
     * current 'auth' user wants to follow 'other' user
     */
    public function store (User $user) {
        return Auth::user()->following()->toggle($user->profile) ;
    }

    public function show (User $user) {
        $latestProfiles = 
            Profile::whereNotIn('user_id', array_merge(
                [ $user->profile->id ],
                $user->following->pluck('id')->toArray()
            ))->get()
        ;
        $latestTags = TweetTag::with("tweets")->limit(5)->get() ;
        // $profile = $user->profile ;

        // $following = ProfileResource::collection($user->following) ;

        // $followers = UserResource::collection($user->profile->followers) ;

        // return view('follows.show', compact('profile', 'user', 'following', 'followers'));
        
        return view('follows.show', [
            'user' => $user,
            'latestProfiles' => $latestProfiles,
            'latestTags' => $latestTags
        ]);
    }
}
