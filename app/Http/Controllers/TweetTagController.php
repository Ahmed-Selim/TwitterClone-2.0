<?php

namespace App\Http\Controllers;

use App\Models\TweetTag;
use App\Http\Requests\StoreTweetTagRequest;
use App\Http\Requests\UpdateTweetTagRequest;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\TweetTagResource;
use App\Http\Resources\TweetResource;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class TweetTagController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']) ;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTweetTagRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTweetTagRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TweetTag  $tweetTag
     * @return \Illuminate\Http\Response
     */
    public function show(TweetTag $tweetTag)
    {
        $tweets = $tweetTag->tweets()->with("profile")->get();
        $latestProfiles = 
            Profile::whereNotIn('user_id', array_merge(
            [ Auth::user()->profile->id ],
            Auth::user()->following->pluck('id')->toArray()
            ))->get()
        ;
        $latestTags = TweetTag::with("tweets")->latest()->limit(5)->get() ;
        return view('tweets.show', [
            'tag' => $tweetTag->tag ,
            'tweets' => $tweets,
            'latestProfiles' => $latestProfiles,
            'latestTags' => $latestTags
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TweetTag  $tweetTag
     * @return \Illuminate\Http\Response
     */
    public function edit(TweetTag $tweetTag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTweetTagRequest  $request
     * @param  \App\Models\TweetTag  $tweetTag
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTweetTagRequest $request, TweetTag $tweetTag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TweetTag  $tweetTag
     * @return \Illuminate\Http\Response
     */
    public function destroy(TweetTag $tweetTag)
    {
        //
    }
}
