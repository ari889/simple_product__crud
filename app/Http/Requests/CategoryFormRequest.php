<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class CategoryFormRequest extends FormRequest
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
        $rules['name'] = ['required', 'string', 'unique:categories,name'];
        $rules['slug'] = ['required', 'string', 'unique:categories,slug'];

        if(request()->update_id){
            $rules['name'] = ['required', 'string', 'unique:categories,name,'.request()->update_id];
            $rules['slug'] = ['required', 'string', 'unique:categories,slug,'.request()->update_id]; 
        }

        return $rules;
    }
}
