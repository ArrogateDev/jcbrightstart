<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Models\Base;
use Illuminate\Validation\Rule;

class ProductRequest extends BaseRequest
{

    public function rules()
    {
        $rules = [
            'name' => [
                'bail',
                'required',
                Rule::unique('products')
            ],
            'picture' => 'bail|required',
            'pictures' => 'bail|nullable|array',
            'vendor_id' => 'bail|required',
            'category_id' => 'bail|required',
            'price' => 'bail|required',
            'on_sale' => 'bail|required|boolean',
            'discount' => 'bail|required|min:0|max:100',
            'cost_of_goods' => 'bail|required',
            'sku' => 'bail|required',
            'status' => 'bail|required|in:0,1'
        ];

        if ($this->method() === 'PUT') {
            $id = $this->segment(3);
            $rules['name'] = [
                'nullable',
                Rule::unique('products')->ignore($id)
            ];
        }

        return $rules;
    }
}
