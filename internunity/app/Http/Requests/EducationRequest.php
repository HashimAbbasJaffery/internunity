<?php

namespace App\Http\Requests;

use App\Rules\FutureDateRule;
use Illuminate\Foundation\Http\FormRequest;

class EducationRequest extends FormRequest
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
            "education" => ["required"],
            "from" => ["required"],
            "description" => ["required"],
            "to" => [new FutureDateRule(request()->from)],
            "organization" => ["required"],
            "grade" => ["required"],
            "type" => ["required"]
        ];
    }
}
