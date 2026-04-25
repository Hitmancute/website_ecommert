<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_name'  => 'required|unique:products,product_name,'.$this->id,
            'category_id'   => 'required|exists:categories,id',
            'is_active'     => 'required',
            'description'     => 'required',
            'image'         => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
        ];
    }
}
