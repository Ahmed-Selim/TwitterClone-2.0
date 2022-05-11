<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Http\Resources\TweetResource;
use App\Models\Tweet;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $users = User::pluck('id')->toArray();
        $gender =  $this->faker->randomElement(['Male', 'Female']) ;
        return [
            'user_id' => User::find($this->faker->unique()->randomElement($users)),
            'name' => $this->faker->name(),
            'username' => $this->faker->userName() ,
            'bio' => $this->faker->paragraph() ,
            'gender' => $gender,
            'birth_date' => $this->faker->date() ,
            'location' => $this->faker->address() ,
            'website' => $this->faker->url() ,
            'profile_image' => '/img/'. $gender.'.png' ,
            'cover_image' => '/img/wallpaper.jpg',
            // 'tweets' => TweetResource::collection($this->faker->randomElements(Tweet::pluck('id')->toArray(),3)),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
