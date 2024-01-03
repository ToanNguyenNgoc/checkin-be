<?php

namespace App\Http\Requests--RequestPath--;

use App\Http\Requests\BaseFormRequest;

class --RequestName-- extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return --RequestAuthorize--;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            '' => [],
        ];
    }
}
