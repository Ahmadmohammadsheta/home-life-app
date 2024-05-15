<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * store validations
     */
    private function storeRequest()
    {
        return [
            'id' => [
                'required', 'exists:categories,id'
            ],
            'name' => ['required', 'string', 'min:3', 'max:255'], //AMA>true
            'parent_id' =>[
                'nullable', 'int', 'exists:categories,id'
            ],
            'image' => [
                'nullable', 'max:1048576', 'dimensions:min_width=100,min_height=100'
            ],
            'all_parents_ids' => [
                'nullable'
            ],
            'is_parent' => [
                'int', 'in:0,1'
            ],
            'type_id' => [
                'required', 'int', 'exists:types,id'
            ]
        ];
    }

    /**
     * update validations
     */
    private function updateRequest()
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'], //AMA>true
            'parent_id' =>[
                'nullable', 'int', 'exists:categories,id'
            ],
            'image' => [
                'nullable', 'max:1048576', 'dimensions:min_width=100,min_height=100'
            ],
            'all_parents_ids' => [
                'nullable'
            ],
            'is_parent' => [
                'int', 'in:0,1'
            ],
            'type_id' => [
                'required', 'int', 'exists:types,id'
            ],
            // 'name' => 'required| unique:customers,name,'.$this->id,  //AMA.true
            // 'name' => ['required', Rule::unique('customers', 'name')->ignore($this->id)], //AMA>true
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return request()->method() == 'PUT' ? $this->updateRequest() : $this->storeRequest();
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages()
    {
        return [
            'name.required' => 'يجب ادخال اسم',
            'name.min' => 'الاسم لا يقل عن 3 احرف'
        ];
    }
}
