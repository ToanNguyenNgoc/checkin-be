<?php

namespace App\Http\Requests\Api\Company;

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
            'id'                => ['nullable', 'numeric'],
            'parent_id'         => ['nullable', 'numeric', Rule::exists('companys', 'id')],
            'is_default'        => ['nullable', 'boolean'],
            'name'              => ['required', 'string', 'max:255'],
            'limited_users'     => ['nullable', 'numeric', 'min:1'],
            'limited_events'    => ['nullable', 'numeric', 'min:1'],
            'limited_campaigns' => ['nullable', 'numeric', 'min:1'],
        ];
    }
}
