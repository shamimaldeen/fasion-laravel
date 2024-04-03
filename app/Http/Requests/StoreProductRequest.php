<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|string",
            "category_id" => "required|numeric",
            "slug" => "required|string|unique:products",
            "brand_id" => "numeric",
            "country_id" => "numeric",
            "sub_category_id" => "numeric",
            "supplier_id" => "numeric",
            "discount_fixed" => "numeric",
            "discount_percent" => "numeric",
            "status" => "required|numeric",
            "cost" => "required|numeric",
            "price" => "required|numeric",
            "stock" => "required|numeric",
            "description" => "string",
        ];
    }
}
