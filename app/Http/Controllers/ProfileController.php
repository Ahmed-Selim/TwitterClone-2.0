<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\TweetTag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function __construct() {
        $this->middleware('auth')->except(['index', 'show']) ;
    }

    /**
     * Show the form for creating a new profile.
     * 
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('profiles.create') ;
    }

    /**
     * Store a newly created profile in storage.
     *
     * @param  \App\Http\Requests\StoreProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreProfileRequest $request) {
        if (!$request['profile_image']) {
            $request['profile_image'] = '/img/'.$request['gender'].'.png' ;
        }
        Auth::user()->profile->create(
            array_merge(
                $request->all(),
                $this->imageArray($request)
            )
        );
        return redirect('/profiles/'.auth()->user()->id);
    }

    /**
     * Display the specified profile.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Profile $profile) {
        $user = $profile->user;
        $latestProfiles = $this->getLatestProfiles($user);
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
     * Show the form for editing the specified profile.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Profile $profile)
    {
        $this->authorize('update', $profile) ;
        return view('profiles.edit', compact('profile'));
    }

    /**
     * Update the specified profile in storage.
     *
     * @param  \App\Http\Requests\UpdateProfileRequest  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\RedirectResponse
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
     * Remove the specified profile from storage.
     *
     * @param  \App\Models\Profile  $profile
     */
    public function destroy(Profile $profile) {
        $profile->delete();
    }

    /**
     * search for profile with keyword
     * @param string $keyword
     * @return \Illuminate\Contracts\View\View
     */
    public function search ($keyword) {
        $profiles = Profile::where("username", "like", "%{$keyword}%")
                ->orWhere("name", "like", "%{$keyword}%")->get() ;
        $latestProfiles = $this->getLatestProfiles(Auth::user());
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

    public static function getLatestProfiles (User $user) {
        return Profile::whereNotIn('user_id', array_merge(
            [ $user->profile->id ],
            $user->following->pluck('id')->toArray()
        ))->get();
    }
}
