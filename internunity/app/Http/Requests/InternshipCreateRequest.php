<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InternshipCreateRequest extends FormRequest
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
            "title" => ["required", "min:5", "max:50"],
            "description" => ["required", "min:100"],
            "stipend" => ["required", "numeric", "gte:15000"],
            "tags" => ["required"]
        ];
    }
    public function messages(): array {
        return [
            "stipend.gte" => 'Minimum stipend must be 15,000 PKR'
        ];
    }
}
