<?php

namespace App\Http\Requests\Product\Update;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'name'        => 'bail|string|min:5|max:255',
            'description' => 'bail|string|min:5|max:2000',
            'price'       => 'bail|numeric',
        ];
    }
}
