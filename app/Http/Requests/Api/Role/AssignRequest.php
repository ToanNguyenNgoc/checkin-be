<?php

namespace App\Http\Requests\Api\Role;

use App\Http\Requests\BaseFormRequest;

class AssignRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id'      => ['required', 'numeric', 'min:1'],
            'role_ids'     => ['required', 'array', 'min:1'],
            'role_ids.*'   => ['required', 'numeric', 'distinct'],
        ];
    }
}
