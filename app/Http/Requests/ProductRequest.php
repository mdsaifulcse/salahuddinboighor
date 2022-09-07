<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|max:255|unique:products,name,NULL,id,deleted_at,NULL',
            'name_bn' => 'required|max:255|unique:products,name_bn,NULL,id,deleted_at,NULL',
            'keyword' => 'nullable|max:200',
            'category_id'=>'required|exists:categories,id',
            'sub_cat_id'=>'nullable|exists:sub_categories,id',
            'third_category_id'=>'nullable|exists:third_sub_categories,id',
            'fourth_category_id'=>'nullable|exists:fourth_sub_categories,id',
            'brand_id'=>'nullable|exists:brands,id',
            'vat_tax_id'=>'nullable|exists:vat_taxes,id',
            'sku' => 'required|max:200|unique:products,sku,NULL,id,deleted_at,NULL',
            'cost_price' => 'required|numeric|max:99999999',
            'sale_price' => 'required|numeric|max:99999999',
            'qty' => 'required|numeric|max:99999999',
            'serial_num' => 'required|numeric|max:99999999',
            //'link' => 'required|unique:products,link,NULL,id,deleted_at,NULL',
            'image' => 'required|array|min:1',
            'image.*' => 'image|mimes:jpg,jpeg,bmp,png,webp,gif|max:15240',
        ];
    }
}
