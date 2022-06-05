<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Http\Requests\StoreTweetRequest;
use App\Http\Requests\UpdateTweetRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\TweetTag;

class TweetController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->except(['index', 'show']) ;
    }

    /**
     * Store a newly created tweet in storage.
     *
     * @param  \App\Http\Requests\StoreTweetRequest  $request
     * @return \App\Models\Tweet
     */
    public function store(StoreTweetRequest $request)
    {
        $tweet = Auth::user()->profile->tweets()
                    ->create($request->all()) ;
        $tweet->save() ;

        if ($request->tags) {
            foreach($request->tags as $tag) {
                $tagIds[] = TweetTag::firstOrCreate(['tag' => $tag])->id;
            }
            $tweet->tags()->attach($tagIds);
        }
        return $tweet ;
    }

    /**
     * Display the specified tweet.
     *
     * @param  \App\Models\Tweet  $tweet
     * @return \App\Models\Tweet
     */
    public function show(Tweet $tweet) {
        return $tweet ;
    }

}
