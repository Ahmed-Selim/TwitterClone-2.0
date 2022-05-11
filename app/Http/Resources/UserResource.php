<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserResource extends ResourceCollection
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
            'email' => $this->email,
            'profile' => $this->profile,
            'followers' => $this->followers,
            'following' => $this->following,
            // 'password' => $this->password,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
