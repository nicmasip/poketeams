<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeamCreateRequest extends FormRequest
{
    function attributes() {
        return [
            'name'       => 'Team name',
            'visibility' => 'Team visibility',
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
        $required = 'The field :attribute is mandatory.';
        $unique = 'The field :attribute of a specific user must be unique in the team table.';
        $max = 'The field :attribute cannot have more than :max characters.';
        $min = 'The field :attribute cannot have less than :min characters.';

        return [
            'name.unique'             => $unique,
            'name.required'           => $required,
            'name.max'                => $max,
            'name.min'                => $min,
            'visibility.required'     => $required,
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
            'name'          => [
                'required',
                'min:2',
                'max:200',
                Rule::unique('team')->where('name', $this->name)->where('iduser', auth()->user()->id)
            ],
            'visibility'    => 'required',
        ];
    }
}
