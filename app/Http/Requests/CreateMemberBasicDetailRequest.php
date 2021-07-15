<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMemberBasicDetailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:50',
            'last_name' => 'string|max:50',
            'blood' => 'required|exists:bloods,id',
            'gender' => 'required|in:1,0',
            'dob' => 'date|required|date_format:Y-m-d|before:18 years ago',
            'religion' => 'required|in:1',
            'mother_tongue' => 'required|exists:mother_tongues,id',
            'email' => 'required|email|unique:member_registration_requests,email',
            'phone_no' => 'required|numeric|regex:/[0-9]{10}/|unique:member_registration_requests,phone_no',
            'profile_photo' => 'image|nullable|mimes:jpeg,png,jpg|max:5240',
            'username' => 'required|string|unique:member_registration_requests,username'
        ];
    }
}
