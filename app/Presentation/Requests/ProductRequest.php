<?php

namespace App\Presentation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products,sku,' . $this->route('product'),
            'specifications' => 'nullable|array',
            'is_active' => 'boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Product name is required',
            'description.required' => 'Product description is required',
            'category.required' => 'Product category is required',
            'price.required' => 'Product price is required',
            'stock_quantity.required' => 'Stock quantity is required',
            'sku.required' => 'SKU is required',
            'sku.unique' => 'SKU must be unique',
            'specifications.array' => 'Specifications must be an array',
            'is_active.boolean' => 'Is active must be true or false'
        ];
    }
}