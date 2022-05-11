<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Http\Requests\StoreTweetRequest;
use App\Http\Requests\UpdateTweetRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TweetResource;
use App\Models\TweetTag;

class TweetController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('tweets.create') ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTweetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTweetRequest $request)
    {
        $tweet = Auth::user()->profile->tweets()->create(
            // array_merge(
            $request->all()
            // , ['image_url' => "/storage/{$image}}"])
        ) ;
    
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
     * Display the specified resource.
     *
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function show(Tweet $tweet)
    {
        return $tweet ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function edit(Tweet $tweet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTweetRequest  $request
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTweetRequest $request, Tweet $tweet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tweet $tweet)
    {
        //
    }
}
