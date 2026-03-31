<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
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
        $id = request('data_category');
        return [
            "category_name" => "required|unique:categories,category_name," . $id,
            "image"         => "nullable|image|mimes:png,jpg,jpeg,gif,svg|max:2040"
        ];
    }

    public function messages()
    {
        return [
            "category_name.required" => "Category name is required",
        ];
    }
}
