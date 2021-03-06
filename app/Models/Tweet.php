<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    protected $guarded = [] ;

    protected $with = ['tags'] ;

    protected $fillable = [
        'profile_id', 'body'
    ];

    public function profile() {
        return $this->belongsTo(Profile::class) ;
    }

    public function tags() {
        return $this->belongsToMany(TweetTag::class, 'tag_tweet', 'tweet_id', 'tag_id') ;
    }
}
