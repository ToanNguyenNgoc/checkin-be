<?php

namespace App\Http\Requests\Api\Permission;

use App\Http\Requests\BaseFormRequest;

class RevokeFromRoleRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'permission_ids' => ['required', 'array', 'min:1'],
        ];
    }
}
