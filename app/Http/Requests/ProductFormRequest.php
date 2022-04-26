<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class ProductFormRequest extends FormRequest
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
        $rules['title'] = ['required', 'string'];
        $rules['thumbnail'] = ['nullable', 'image', 'mimes:png,jpg,jpeg,gif'];
        $rules['description'] = ['nullable', 'max:5000'];
        $rules['price'] = ['required', 'numeric'];
        $rules['subcategory_id'] = ['required', 'integer'];

        return $rules;
    }
}
