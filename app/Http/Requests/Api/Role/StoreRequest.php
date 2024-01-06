<?php

namespace App\Http\Requests\Api\Role;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles')->where(function ($query) {
                    $guardName = $this->guard_name ?? 'api';
                    return $query->where('guard_name', $guardName);
                }),
            ],
            'guard_name' => ['nullable', 'string', 'max:255']
        ];
    }
}
