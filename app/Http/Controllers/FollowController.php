<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\TweetTag;

class FollowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth') ;
    }

    /**
     * current 'auth' user wants to follow 'other' user
     */
    public function toggleFollow (User $user) {
        return Auth::user()->following->toggle($user->profile) ;
    }

    public function show (User $user) {
        $latestProfiles = ProfileController::getLatestProfiles($user);
        $latestTags = TweetTag::with("tweets")->limit(5)->get() ;
        
        return view('follows.show', [
            'user' => $user,
            'latestProfiles' => $latestProfiles,
            'latestTags' => $latestTags
        ]);
    }
}
