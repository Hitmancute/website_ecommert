<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
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
            "category_name" => "required|unique:categories",
            "image" => "required|image|mimes:png,jpg,jpeg,gif,svg|max:2040"
        ];
    }

    public function messages()
    {
        return [
            "category_name.required" => "Category name is required",
            "image.required" => "Image is required",
        ];
    }
}
