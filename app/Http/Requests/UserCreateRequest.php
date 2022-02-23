<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    function attributes() {
        return [
            'name'          => 'User name',
            'email'         => 'User email address',
            'password'      => 'User password',
            'role'          => 'User role',
        ];
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    
    function messages() {
        $max = 'The field :attribute cannot have more than :max characters.';
        $min = 'The field :attribute cannot have less than :min characters.';
        $required = 'The field :attribute is mandatory.';
        $unique   = 'The field :attribute must be unique in the users table.';

        return [
            'name.max'          => $max,
            'name.required'     => $required,
            'name.unique'       => $unique,
            'email.max'         => $max,
            'email.min'         => $min,
            'email.required'    => $required,
            'email.unique'      => $unique,
            'password.min'      => $min,
            'role.required'     => $required,
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required|min:2|max:255|unique:users,name',
            'email'         => 'required|email|min:5|max:255|unique:users,email',
            'password'      => 'nullable|min:8',
            'role'          => 'required',
        ];
    }
}
