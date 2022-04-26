<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class SubcategoryFormRequest extends FormRequest
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
        $rules['category_id'] = ['required', 'integer'];
        $rules['name'] = ['required', 'string', 'unique:sub_categories,name'];
        $rules['slug'] = ['required', 'string', 'unique:sub_categories,slug'];

        if(request()->update_id){
            $rules['name'] = ['required', 'string', 'unique:sub_categories,name,'.request()->update_id];
            $rules['slug'] = ['required', 'string', 'unique:sub_categories,slug,'.request()->update_id]; 
        }

        return $rules;
    }
}
