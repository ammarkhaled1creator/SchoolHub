<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSchoolTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for updating a school type.
     * The unique rule ignores the current record's own id.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $schoolType = $this->route('schoolType');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('school_types', 'name')->ignore($schoolType),
            ],
        ];
    }
}
