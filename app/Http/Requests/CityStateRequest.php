<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CityStateRequest extends FormRequest
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
            'state' => [
                'required',
                'exists:states,id', // Check if the state ID exists in the 'states' table
            ],
            // Add more validation rules as needed
        ];
    }
}
