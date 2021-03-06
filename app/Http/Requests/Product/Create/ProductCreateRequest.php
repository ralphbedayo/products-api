<?php

namespace App\Http\Requests\Product\Create;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
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
            'name'        => 'required|string|min:5|max:255',
            'description' => 'required|string|min:5|max:2000',
            'price'       => 'required|numeric',
        ];
    }
}
