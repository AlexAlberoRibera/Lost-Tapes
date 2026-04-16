<?php

/*
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product')->id;

        return [
            'sku' => 'sometimes|required|unique:products,sku,' . $productId,
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'image' => 'sometimes|nullable|string|max:255',
            'category' => 'sometimes|required|string',
        ];
    }
}
*/

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // ⚠️ Importante: debe ser true
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sku' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|string|max:255',
            'category' => 'required|string|in:pelicula', // Ajusta según tus categorías
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'sku.required' => 'El SKU es obligatorio.',
            'name.required' => 'El nombre es obligatorio.',
            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un número.',
            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'category.required' => 'La categoría es obligatoria.',
            'category.in' => 'La categoría seleccionada no es válida.',
        ];
    }
}