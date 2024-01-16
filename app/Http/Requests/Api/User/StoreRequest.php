<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;

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
            'id'                => ['nullable', 'numeric'],
            'role_id'           => ['nullable', 'numeric', $this->tableHasId('roles')],
            'name'              => ['required', 'string', 'max:255'],
            'username'          => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'max:255'],
            'status'            => ['required', 'string', 'max:50', Rule::in(array_keys(User::getStatuesValid()))],
        ];
    }
}
