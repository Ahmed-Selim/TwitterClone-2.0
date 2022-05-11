<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\TweetTagResource;
use App\Models\TweetTag;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']) ;
        // $this->authorizeResource(Profile::class);
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
        return view('profiles.create') ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProfileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProfileRequest $request)
    {
        if (!$request['profile_image'])
        {
            $request['profile_image'] = '/img/'.$request['gender'].'.png' ;
        }
        Auth::user()->profile()->create(
            array_merge(
                $request->all(),
                $this->imageArray($request)
            )
        );

        return redirect('/profiles/'.auth()->user()->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        // $user = new UserResource($profile->user);
        $user = $profile->user;
        $latestProfiles = 
            // Profile::latest()->limit(5)->get()->toArray() ;
            Profile::whereNotIn('user_id', array_merge(
                [ $profile->id ],
                $profile->user->following->pluck('id')->toArray()
            ))->get();
        // return $latestProfiles ;
        $latestTags = TweetTag::with('tweets')->latest()->limit(5)->get();
        $follows = $this->isFollowing($user->profile) ;
        return view ('profiles.show', [
            'user' => $user,
            'follows' => $follows,
            'latestProfiles' => $latestProfiles,
            'latestTags' => $latestTags
        ]) ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        $this->authorize('update', $profile) ;
        return view('profiles.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProfileRequest  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $request, Profile $profile)
    {
        $this->authorize('update', $profile) ;

        Auth::user()->profile->update(
            array_merge(
                $request->except(['_token', '_method']),
                $this->imageArray($request)
            )
        );
        return redirect("/profiles/{$profile->id}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        $profile->delete();
    }

    public function search ($pro) {
        $profiles = 
            Profile::where("username", "like", "%{$pro}%")
                ->orWhere("name", "like", "%{$pro}%")->get() 
        ;
        $latestProfiles = 
        // Profile::latest()->limit(5)->get()->toArray() ;
            Profile::whereNotIn('user_id', array_merge(
                [ auth()->user()->profile->id ],
                auth()->user()->following->pluck('id')->toArray()
            ))->get()
        ;
        $latestTags = TweetTag::with('tweets')->latest()->limit(5)->get();
        return view("profiles.search", [
            'profiles' => $profiles,
            'latestProfiles' => $latestProfiles,
            'latestTags' => $latestTags
        ]) ;
    }

    public function isFollowing (Profile $profile) {
        return (Auth::user())
        ? Auth::user()->following->contains($profile)
        : false ;
    }

    private function storeImage ($image) {
        $imagePath = $image->store('uploads', 'public') ;
        return '/storage/' . $imagePath ;
    }

    private function imageArray ($request) : array {
        if ($request['profile_image']) {
            $profile_image = [
                'profile_image' => $this->storeImage($request['profile_image'])
            ] ;
        }

        if ($request['cover_image']) {
            $cover_image = [
                'cover_image' => $this->storeImage($request['cover_image'])
            ];
        }

        return array_merge(
            $profile_image ?? [],
            $cover_image ?? []
        );
    }
}
