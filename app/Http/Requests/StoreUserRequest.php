<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $userType = $this->input('user_type');

        $rules = [
            "name" => ['required', 'string', 'max:255'],
            "email" => ['required', 'string', 'max:255', 'unique:users'],
            "password" => ['required', 'confirmed', 'string', 'min:6'], 
        ];

        if ($userType === 'admin') {
             $rules = [
                    "name" => ['required', 'string', 'max:255'],
                    "email" => ['required', 'string', 'max:255', 'unique:admin_users'],
                    "password" => ['required', 'confirmed', 'string', 'min:6'],
             ];
        }
        return $rules;
    }
}
