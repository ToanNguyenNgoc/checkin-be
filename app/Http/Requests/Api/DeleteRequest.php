<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseFormRequest;

class DeleteRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'numeric', 'min:1'],
        ];
    }
}
