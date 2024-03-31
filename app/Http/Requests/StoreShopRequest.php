<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShopRequest extends FormRequest
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
            "email" => "required|string|unique:suppliers",
            "contact" => "required|string",
            "landmark" => "required|string",
            "status" => "required|numeric",
            "address" => "required|string",
            "division_id" => "required|numeric",
            "district_id" => "required|numeric",
            "area_id" => "required|numeric",
        ];
    }
}
