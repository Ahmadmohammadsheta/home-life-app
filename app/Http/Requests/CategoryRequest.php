<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
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
                'nullable', 'exists:categories,id'
            ],
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('categories', 'name')
            ], //AMA>true
            'parent_id' =>[
                'nullable',
                'int',
                'exists:categories,id'
            ],
            'image' => [
                'nullable',
                'max:1048576',
                'dimensions:min_width=100,min_height=100'
            ],
            'all_parents_ids' => [
                'nullable'
            ],
            'is_parent' => [
                'int', 'in:0,1'
            ],
            'type_id' => [
                'required',
                'int',
                'exists:types,id'
            ]
        ];
    }

    /**
     * update validations
     */
    private function updateRequest($id)
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                // "unique:categories,name,$this->id",
                Rule::unique('categories', 'name')->ignore($id)
            ], //AMA>true
            'parent_id' =>[
                'nullable',
                'int',
                'exists:categories,id'
            ],
            'image' => [
                'nullable',
                'max:1048576',
                'dimensions:min_width=100,min_height=100'
            ],
            'all_parents_ids' => [
                'nullable'
            ],
            'is_parent' => [
                'int', 'in:0,1'
            ],
            'type_id' => [
                'required',
                'int',
                'exists:types,id'
            ],
            // 'name' => "required| unique:customers,name,$this->id",  //AMA.true
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
    public function rules($id = 0)
    {
        $id = (request()->route('category'));
        return request()->method() == 'PUT' ? $this->updateRequest($id) : $this->storeRequest();
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages()
    {
        return [
            'unique' => 'The value of (:attribute) is exists',
            'name.required' => 'The field (:attribute) is required',
            'name.min' => 'The field (:attribute) must be more than 3 charachters'
        ];
    }
}
