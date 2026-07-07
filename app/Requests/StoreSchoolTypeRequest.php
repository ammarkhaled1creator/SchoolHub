<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchoolTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Route-level middleware already restricts this to admins,
     * so we just allow it here.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for creating a school type.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:school_types,name'],
        ];
    }
}
