<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRegistrationSaveRequest extends FormRequest
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
        $id = $this->id ?? null;
        return [
            'represent_by' => 'required|exists:represent_bies,slug',
            'first_name' => 'required|alpha|max:50',
            'last_name' => 'nullable|alpha|max:50',
            //'blood' => 'nullable|exists:bloods,id',
            'gender' => 'required|in:1,2',
            'dob' => 'date|required|date_format:d-m-Y|before:18 years ago',
            'religion' => 'required|in:1',
            'mother_tongue' => 'required|exists:mother_tongues,id',
            'email' => 'required|email|unique:member_registration_requests,email',
            'phone_no' => 'required|numeric|unique:member_registration_requests,phone_no|unique:members,phone_no|regex:/[0-9]{10}/',
            'username' => "required|string|max:30|unique:member_registration_requests,username,{$id},id,deleted_at,NULL",
            'password' => 'required|string|min:6|max:30',
            'confirm_password' => 'required|string|same:password'
        ];
    }

    public function messages()
    {
        return [
            'phone_no.unique' => 'It look phone number already registered. Try Login with password of your date of birth (DDMMYYYY)'
        ];
    }
}
