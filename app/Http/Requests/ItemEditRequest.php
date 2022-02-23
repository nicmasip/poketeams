<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemEditRequest extends FormRequest
{
    function attributes() {
        return [
            'name'           => 'Name of the item',
            'description'    => 'Description of the item',
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
        $unique   = 'The field :attribute must be unique in the item table.';

        return [
            'name.max'                 => $max,
            'name.min'                 => $min,
            'name.required'            => $required,
            'name.unique'              => $unique,
            'description.max'          => $max,
            'description.min'          => $min,
            'description.required'     => $required,
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
            'name'          => 'required|min:2|max:100|unique:item,name,' . $this->item->id,
            'description'   => 'required|min:2|max:2000',
        ];
    }
}
