<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PokemonCreateRequest extends FormRequest
{
    function attributes() {
        return [
            'name'      => 'Name of the pokémon',
            'height'    => 'Height of the pokémon',
            'weight'    => 'Weight of the pokémon',
            'region'    => 'Region where the pokémon is from',
            'image'     => 'Image of the pokémon',
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
        $unique   = 'The field :attribute must be unique in the pokémon table.';
        $gte = 'The field :attribute must be greater or equal than :value.';
        //$integer = 'The field :attribute must be an integer.';
        $lte = 'The field :attribute mus be lesser or equal than :value.';
        $numeric = 'The field :attribute must be numeric.';
        $file = 'The field :attribute must be a file.';
        $image = 'The file must be an image.';
        $mimes = 'The following extensions are accepted: .jpg, .png, .bmp';

        return [
            'name.max'          => $max,
            'name.min'          => $min,
            'name.required'     => $required,
            'name.unique'       => $unique,
            'height.gte'        => $gte,
            'height.lte'        => $lte,
            'height.numeric'    => $numeric,
            'height.required'   => $required,
            'weight.gte'        => $gte,
            'weight.lte'        => $lte,
            'weight.numeric'    => $numeric,
            'weight.required'   => $required,
            'region.required'   => $required,
            'image.file'        => $file,
            'image.image'       => $image,
            'image.mimes'       => $mimes,
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
            'name'     => 'required|min:2|max:200|unique:pokemon,name',
            'height'   => 'required|numeric|gte:0.1|lte:200.0',
            'weight'   => 'required|numeric|gte:0.1|lte:1000.0',
            'region'   => 'required',
            'image'    => 'file|image|mimes:jpg,bmp,png',
        ];
    }
}
