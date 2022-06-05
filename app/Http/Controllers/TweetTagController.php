<?php

namespace App\Http\Controllers;

use App\Models\TweetTag;
use App\Http\Requests\StoreTweetTagRequest;
use App\Http\Requests\UpdateTweetTagRequest;
use Illuminate\Support\Facades\Cache;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class TweetTagController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->except(['index', 'show']) ;
    }
    /**
     * Display a listing of the tweettag.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        $tags = Cache::remember(
            'tags', now()->addSeconds(30), function () {
                return TweetTag::with('tweets')->latest()->get() ;
        });

        return $tags ;
    }

    /**
     * Display the specified tweettag.
     *
     * @param  \App\Models\TweetTag  $tweetTag
     * @return \Illuminate\Contracts\View\View
     */
    public function show(TweetTag $tweetTag) {
        $tweets = $tweetTag->tweets()->with("profile")->get();
        $latestProfiles = ProfileController::getLatestProfiles(Auth::user());
        $latestTags = TweetTag::with("tweets")->latest()->limit(5)->get() ;
        return view('tweets.show', [
            'tag' => $tweetTag->tag ,
            'tweets' => $tweets,
            'latestProfiles' => $latestProfiles,
            'latestTags' => $latestTags
        ]);
    }
}
