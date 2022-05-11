<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [ 'string', 'min:4', 'max:255'],
            'username' => [ 'string', 'min:4', 'max:255', 'unique:profiles,username,'.($this->user()->id)],
            'bio' => ['nullable', 'string'],
            'gender' => [ 'string', 'in:male,female'],
            'birth_date' => [ 'date', 'before_or_equal:'.(Carbon::now()->subYears(18))],
            'location' => [ 'string', 'min:3', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
            'cover_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg']
        ];
    }

    public function messages()
    {
        return [
            'birth_date.before_or_equal' => 'Your age is under 18 years old!'
        ];
    }
}
