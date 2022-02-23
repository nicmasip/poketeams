<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileEditRequest extends FormRequest
{
    function attributes() {
        return [
            'name'          => 'User name',
            'email'         => 'User email address',
            'password'      => 'User password',
            'oldpassword'   => 'Old user password',
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
            'oldpassword.min'   => $min,
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
            'name'          => 'required|max:255|min:2|unique:users,name,' . auth()->user()->id,
            'email'         => 'required|email|min:5|max:255|unique:users,email,' . auth()->user()->id,
            'password'      => 'nullable|min:8|confirmed',
            'oldpassword'   => 'nullable|min:8',
        ];
    }
}
