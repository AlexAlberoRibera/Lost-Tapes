<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sku'         => 'required|string|max:50|unique:products,sku',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|string|max:255',
            'category'    => 'required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'sku.required'      => 'El SKU es obligatorio.',
            'sku.unique'        => 'Ya existe un producto con ese SKU.',
            'name.required'     => 'El nombre es obligatorio.',
            'price.required'    => 'El precio es obligatorio.',
            'price.numeric'     => 'El precio debe ser un número.',
            'stock.required'    => 'El stock es obligatorio.',
            'stock.integer'     => 'El stock debe ser un número entero.',
            'category.required' => 'La categoría es obligatoria.',
        ];
    }
}
