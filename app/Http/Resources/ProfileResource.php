<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProfileResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'username' => $this->username ,
            'bio' => $this->bio ,
            'gender' => $this->gender ,
            'birth_date' => $this->birth_date ,
            'location' => $this->location ,
            'website' => $this->website ,
            'profile_image' => $this->profile_image ,
            'cover_image' => $this->cover_image,
            'tweets' => TweetResource::collection($this->latestTweets),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
